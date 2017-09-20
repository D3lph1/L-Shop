<?php
declare(strict_types = 1);

namespace App\Services\Distributors;

use App\Exceptions\FailedToUpdateTableException;
use App\Exceptions\UnexpectedValueException;
use App\Models\Payment\PaymentInterface;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Traits\ContainerTrait;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Distributor
 * Parent class for all distributors.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Distributors
 */
abstract class Distributor
{
    use ContainerTrait;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var PaymentRepositoryInterface
     */
    protected $paymentRepository;

    /**
     * @var Sentinel
     */
    protected $sentinel;

    /**
     * @var string
     */
    protected $user;

    /**
     * Distributor constructor.
     */
    public function __construct()
    {
        $this->productRepository = $this->make(ProductRepositoryInterface::class);
        $this->paymentRepository = $this->make(PaymentRepositoryInterface::class);
        $this->sentinel = $this->make(Sentinel::class);
    }

    /**
     * Gives products to the player.
     */
    abstract public function give(PaymentInterface $payment): void;

    protected function productsWithItems(string $serialized): array
    {
        $unserialized = unserialize($serialized);
        // Array with products identifiers.
        $identifiers = array_keys($unserialized);
        $counts = array_values($unserialized);

        /** @var Collection $products */
        $products = $this->productRepository->withItemsMultiple(
            $identifiers,
            ['server_id', 'stack', 'item_id'],
            ['item', 'type', 'extra']
        );

        return $this->setCounts($counts, $products);
    }

    private function setCounts(array $counts, iterable $products): array
    {
        $result = [];

        for ($i = 0; $i < count($counts); $i++) {
            $result['count'] = $counts[$i];
        }

        return $result;
    }

    /**
     *
     */
    protected function getUsername(PaymentInterface $payment): string
    {
        // If the order was made by an NOT authorized user.
        if ($payment->getUsername()) {
            return $payment->getUsername();
        }

        // If the order was made by an authorized user.
        if ($payment->getUserId()) {
            return $payment->getUser()->getUsername();
        }

        // If for some reason both fields are empty.
        throw new UnexpectedValueException(
            "Columns `user_id` and `username` is empty in row with id {$payment->getId()}"
        );
    }

    /**
     * Completes the current payment.
     */
    protected function complete(PaymentInterface $payment)
    {
        if (!$payment->isCompleted()) {
            if (!$this->paymentRepository->complete($payment->getId(), $payment->getService())) {
                throw new FailedToUpdateTableException(
                    "Can not complete the payment with id {$payment->getId()}"
                );
            }
        }
    }
}
