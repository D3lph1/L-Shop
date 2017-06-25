<?php

namespace App\Services\Distributors;

use App\Models\Payment;
use App\Services\QueryManager;
use App\Exceptions\FailedToUpdateTableException;

/**
 * Class Distributor
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Distributors
 */
abstract class Distributor
{
    /**
     * @var QueryManager
     */
    protected $qm;

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
     * @param QueryManager $qm
     */
    public function __construct(QueryManager $qm)
    {
        $this->qm = $qm;
    }

    /**
     * @param string $serialized
     *
     * @return array
     */
    protected function convertProductsString($serialized)
    {
        $unserialized = unserialize($serialized);
        $ids = array_keys($unserialized);
        $counts = array_values($unserialized);

        $products = $this->qm->product($ids, [
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
     * @param array $counts
     * @param array $products
     *
     * @return array
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

    protected function setUser()
    {
        if ($this->payment->username) {
            $this->user = $this->payment->username;
            return;
        }
        if ($this->payment->user_id) {
            $this->user = \Sentinel::getUserRepository()->findById($this->payment->user_id)['username'];
            return;
        }
        throw new \UnexpectedValueException(
            "Columns `user_id` and `username` is empty in row with id {$this->payment->id}"
        );
    }

    /**
     * @throws FailedToUpdateTableException
     */
    protected function complete()
    {
        if (!$this->payment->completed) {
            if (!$this->qm->completePayment($this->payment->id, $this->payment->service)) {
                throw new FailedToUpdateTableException("Can not complete the payment with id {$this->payment->id}");
            }
        }
    }

    /**
     * @param Payment $payment
     *
     * @return void
     */
    abstract public function give(Payment $payment);
}
