<?php
declare(strict_types = 1);

namespace App\TransactionScripts;

use App\DataTransferObjects\Methods;
use App\DataTransferObjects\Payment;
use App\Exceptions\LogicException;
use App\Exceptions\Payment\AlreadyCompletedException;
use App\Exceptions\Payment\NotFoundException;
use App\Models\Payment\PaymentInterface;
use App\Models\Product\ProductInterface;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Distributors\Distributor;
use App\Services\Image;
use App\Services\Payments\Interkassa\Checkout as InterkassaCheckout;
use App\Services\Payments\Interkassa\Payment as InterkassaPayment;
use App\Services\Payments\Robokassa\Checkout as RobokassaCheckout;
use App\Services\Payments\Robokassa\Payment as RobokassaPayment;
use App\Services\User\Balance;
use App\Traits\ContainerTrait;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class Payments
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\TransactionScripts
 */
class Payments
{
    use ContainerTrait;

    /**
     * @var PaymentRepositoryInterface
     */
    private $paymentRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository, ProductRepositoryInterface $productRepository, Sentinel $sentinel)
    {
        $this->paymentRepository = $paymentRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $sentinel->getUserRepository();
    }

    public function informationForList()
    {
        return $this->paymentRepository->withUserPaginated(
            ['id', 'service', 'products', 'cost', 'server_id', 'completed', 'created_at', 'updated_at'],
            ['username']
        );
    }

    public function informationForHistory(int $paymentId): array
    {
        $payment = $this->paymentRepository->find($paymentId, ['products']);

        if (is_null($payment)) {
            throw new NotFoundException($paymentId);
        }

        $unserialized = $payment->getProducts();
        $identifiers = array_keys($unserialized);
        $products = $this->productRepository->withItemsMultiple($identifiers, ['id'], ['name', 'image']);
        $result = [];

        /** @var ProductInterface $product */
        foreach ($products as &$product) {
            foreach ($unserialized as $key => $value) {
                if ($product->getId() === $key) {
                    $tmp = [];
                    $tmp['name'] = $product->getItem()->getName();
                    $tmp['count'] = $value;
                    $tmp['image'] = Image::getOrDefault('items/' . $product->getItem()->getImage(), 'empty.png');
                    $result[] = $tmp;
                }
            }
        }

        return $result;
    }

    public function informationForUser(int $userId): LengthAwarePaginator
    {
        return $this->paymentRepository->historyForUser(
            $userId,
            ['id', 'service', 'products', 'user_id', 'cost', 'user_id', 'username', 'server_id', 'ip', 'completed', 'created_at', 'updated_at']
        );
    }

    public function complete(int $paymentId): bool
    {
        /** @var Distributor $distributor */
        $distributor = $this->make(Distributor::class);
        $payment = $this->paymentRepository->find($paymentId, ['*']);

        if (is_null($payment)) {
            throw new NotFoundException($paymentId);
        }

        if ($payment->isCompleted()) {
            throw new AlreadyCompletedException($paymentId);
        }

        if (count($payment->getProducts()) === 0) {
            Balance::add($payment->getUser(), $payment->getCost());
        }

        $this->paymentRepository->complete($payment->getId(), __('content.profile.payments.table.completed_by_admin'));

        if (count($payment->getProducts()) !== 0) {
            $distributor->give($payment);
        }

        return true;
    }

    public function methods(int $paymentId): Methods
    {
        /** @var PaymentInterface $payment */
        $payment = $this->paymentRepository->find($paymentId, ['id', 'cost', 'user_id', 'username', 'completed']);

        if (is_null($payment)) {
            throw new NotFoundException($paymentId);
        }

        // If the payment is completed, deny access.
        if ($payment->isCompleted()) {
            throw new AlreadyCompletedException($paymentId);
        }

        // Verification of whether the payment the user belongs.
        if (is_null($payment->getUsername())) {
            if (!is_auth()) {
                // If it is not, deny access.
                throw new LogicException();
            }

            if ($payment->getUserId() != $payment->getUser()->getId()) {
                // If it is not, deny access.
                throw new LogicException();
            }
        }

        return new Methods($this->robokassa($payment), $this->interkassa($payment));
    }

    private function robokassa(PaymentInterface $payment): ?string
    {
        if (!s_get('payment.method.robokassa.enabled')) {
            return null;
        }

        /** @var RobokassaCheckout $checkout */
        $checkout = $this->make(RobokassaCheckout::class);
        $payment = new RobokassaPayment($payment->getId(), $payment->getCost());
        $payment->setDescription(s_get('shop.name'));

        return $checkout->getPaymentUrl($payment);
    }

    private function interkassa(PaymentInterface $payment): ?string
    {
        if (!s_get('payment.method.interkassa.enabled')) {
            return null;
        }

        /** @var InterkassaCheckout $checkout */
        $checkout = $this->make(InterkassaCheckout::class);
        $payment = new InterkassaPayment($payment->getId(), $payment->getCost());
        $payment->setDescription(s_get('shop.name'));
        $payment->setCurrency(s_get('payment.method.interkassa.currency'));

        return $checkout->getPaymentUrl($payment);
    }

    public function fillupbalance(int $userId, float $sum, int $serverId, string $ip): ?PaymentInterface
    {
        $sum = (float)abs($sum);

        $payment = $this->paymentRepository->create(
            (new Payment())
                ->setProducts(null)
                ->setCost($sum)
                ->setUserId($userId)
                ->setServerId($serverId)
                ->setIp($ip)
                ->setCompleted(false)
        );

        return $payment;
    }
}
