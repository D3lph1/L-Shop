<?php

namespace App\Services\Distributors;

use App\Models\Payment;
use App\Contracts\Distributor;
use App\Services\QueryManager;
use App\Exceptions\FailedToInsertException;
use Carbon\Carbon;

/**
 * Class ShoppingCart
 * It produces goods issue in the player shopping cart plugin table
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Distributors
 */
class ShoppingCart implements Distributor
{
    /**
     * @var int
     */
    private $id;

    private $unserialized;

    /**
     * @var int
     */
    private $user;

    /**
     * @var int
     */
    private $server;

    /**
     * @var Payment
     */
    private $payment;

    /**
     * @var QueryManager
     */
    private $qm;

    /**
     * @param QueryManager $qm
     */
    public function setQm(QueryManager $qm)
    {
        $this->qm = $qm;
    }

    /**
     * @param Payment $payment
     */
    public function give(Payment $payment)
    {
        $this->id = $payment->id;
        $this->payment = $payment;
        $products = $this->getProducts();
        $this->setUser();
        $this->setServer();
        $this->giveProducts($products);
    }

    /**
     * @return mixed
     */
    private function getProducts()
    {
        $this->unserialized = unserialize($this->payment->products);
        $ids = array_keys($this->unserialized);
        return $this->qm->product(
            $ids,
            [
                'products.server_id as server',
                'items.item as item',
                'items.extra as extra',
                'items.type as type',
                'products.stack as stack'
            ]
        );
    }

    /**
     * Sets the user name that will be added products
     */
    private function setUser()
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
     * Set the server on which the goods will be credited to the player
     */
    private function setServer()
    {
        $this->server = $this->payment->server_id;
    }

    /**
     * @param $products
     *
     * @throws FailedToInsertException
     */
    private function giveProducts($products)
    {
        $credentials = [];
        $i = 0;
        $counts = array_values($this->unserialized);
        foreach ($products as $product) {
            $credentials[] = [
                'server' => $product->server,
                'player' => $this->user,
                'type' => $product->type,
                'item' => $product->item,
                'amount' => $product->stack * $counts[$i],
                'extra' => $product->extra,
                'created_at' => Carbon::now()->toDateTimeString()
            ];
            $i++;
        }

        if (!$this->qm->putInShoppingCart($credentials)) {
            throw new FailedToInsertException(
                "Failed to send payment with id {$this->payment->id}"
            );
        }
    }
}
