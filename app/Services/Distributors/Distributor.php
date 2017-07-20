<?php

namespace App\Services\Distributors;

use App\Exceptions\FailedToUpdateTableException;
use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
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
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var PaymentRepository
     */
    protected $paymentRepository;

    /**
     * @var Payment
     */
    protected $payment;

    /**
     * @var string
     */
    protected $user;

    /**
     * Distributor constructor.
     *
     * @param ProductRepository $productRepository
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(
        ProductRepository $productRepository,
        PaymentRepository $paymentRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @param string $serialized
     *
     * @return Collection
     */
    protected function productsWithItems($serialized)
    {
        $unserialized = unserialize($serialized);
        // Array with products identifiers.
        $ids = array_keys($unserialized);
        $counts = array_values($unserialized);

        /** @var Collection $products */
        $products = $this->productRepository->getWithItems($ids, [
            'products.server_id as server',
            'items.item as item',
            'items.extra as extra',
            'items.type as type',
            'products.stack as stack',
            'products.item_id as item_id'
        ]);

        return $this->setCounts($counts, $products);
    }

    /**
     * @param array      $counts
     * @param Collection $products
     *
     * @return Collection
     */
    private function setCounts($counts, $products)
    {
        $i = 0;
        foreach ($products as &$product) {
            $product->count = $counts[$i];
            $i++;
        }

        return $products;
    }

    /**
     * Sets the user to whom the products will be issued.
     */
    protected function setUser()
    {
        // If the order was made by an NOT authorized user.
        if ($this->payment->username) {
            $this->user = $this->payment->username;

            return;
        }

        // If the order was made by an authorized user.
        if ($this->payment->user_id) {
            $this->user = \Sentinel::getUserRepository()->findById($this->payment->user_id)['username'];

            return;
        }

        // If for some reason both fields are empty.
        throw new \UnexpectedValueException(
            "Columns `user_id` and `username` is empty in row with id {$this->payment->id}"
        );
    }

    /**
     * Completes the current payment.
     *
     * @throws FailedToUpdateTableException
     */
    protected function complete()
    {
        if (!$this->payment->completed) {
            if (!$this->paymentRepository->complete($this->payment->id, $this->payment->service)) {
                throw new FailedToUpdateTableException(
                    "Can not complete the payment with id {$this->payment->id}"
                );
            }
        }
    }

    /**
     * Gives products to the player.
     *
     * @param Payment $payment
     *
     * @return void
     */
    abstract public function give(Payment $payment);
}
