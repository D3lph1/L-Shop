<?php

namespace App\Http\Controllers;

use App\Traits\Validator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, Validator;

    /**
     * @var Application
     */
    protected $app;

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
        $this->cart = \App::make('cart');
        $this->app = \App::make('app');
    }
}
