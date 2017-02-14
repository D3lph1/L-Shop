<?php

namespace App\Http\Controllers\Components;

use App\Services\Cart;
use App\Services\QueryManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Server id
     *
     * @var int
     */
    private $server;

    private $cart;

    private $qm;

    private $products;

    private $cost;

    private $productsQueryString;

    public function __construct(Cart $cart, QueryManager $qm)
    {
        $this->cart = $cart;
        $this->qm = $qm;
    }

    public function render(Request $request)
    {
        $this->server = (int)$request->route('server');

        $server = $this->qm->serverOrFail($this->server, ['id', 'name']);
        $servers = $this->qm->listOfEnabledServers(['id', 'name']);

        $data = [
            'currentServer' => $server,
            'servers' => $servers,

            'robokassa' => (bool)s_get('payment.method.robokassa.enabled') ? $this->robokassa() : null
        ];
        return view('payment.methods', $data);
    }

    private function robokassa()
    {
        $instance = \App::make('payment.robokassa');
        $this->construct();
        $invoice = $instance->make(1, $this->productsQueryString, $this->cost);
        return $instance->build($invoice);
    }

    private function construct()
    {
        $cart = $this->cart;
        $qm = $this->qm;

        // Get all goods from cart for current server
        $all = $cart->getAll($this->server);
        $productsQueryString = '';
        $count = count($all);
        $i = 1;
        $products = [];
        $cost = 0;

        foreach ($all as $key => $value) {
            // Get product data from database
            $product = $qm->product($key);
            $products[] = $product;
            // Summ products cost
            $cost += $product[0]->price;
            // Construct string with products id and count
            $productsQueryString .= $key . 'x' . 1;
            if ($i != $count) {
                $productsQueryString .= ',';
            }

            $i++;
        }

        $this->products = $products;
        $this->cost = $cost;
        $this->productsQueryString = $productsQueryString;
    }
}
