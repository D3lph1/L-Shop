<?php
declare(strict_types = 1);

namespace App\TransactionScripts;

use App\Exceptions\Payment\AlreadyCompletedException;
use App\Exceptions\Payment\NotFoundException;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Distributors\Distributor;
use App\Services\Image;
use App\Traits\ContainerTrait;
use Cartalyst\Sentinel\Sentinel;

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
        return $this->paymentRepository->withUserPaginated(['*'], ['*']);
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
            refill_user_balance((float)$payment->getCost(), $payment->getUserId());
            $this->paymentRepository->complete($payment->getId(), __('content.profile.payments.table.completed_by_admin'));
        }

        $distributor->give($payment);

        return true;
    }
}
