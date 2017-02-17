<?php

namespace App\Services\Payments;

use App\Services\Cart;
use App\Services\QueryManager;

abstract class Manager
{
    /**
     * Server id
     *
     * @var int
     */
    protected $server;

    /**
     * @var QueryManager
     */
    protected $qm;

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @param QueryManager $qm
     * @param Cart         $cart
     */
    public function __construct(QueryManager $qm, Cart $cart)
    {
        $this->qm = $qm;
        $this->cart = $cart;
    }

    public function refillBalance()
    {
        //
    }

    public function quickPay()
    {
        //
    }
}
