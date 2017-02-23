<?php

namespace App\Http\Controllers;

use App\Traits\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, Validator;

    /**
     * @var \App\Services\QueryManager
     */
    protected $qm;

    /**
     * @var \App\Services\Cart
     */
    protected $cart;

    /**
     * @var int
     */
    protected $server;

    public function __construct()
    {
        $this->qm = \App::make('qm');
        $this->cart = \App::make('cart');
    }
}
