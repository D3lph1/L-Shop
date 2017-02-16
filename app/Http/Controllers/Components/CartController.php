<?php

namespace App\Http\Controllers\Components;

use App\Services\Cart;
use App\Services\QueryManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class CartController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Components
 */
class CartController extends Controller
{
    /**
     * @var int
     */
    private $server;

    /**
     * @var QueryManager
     */
    private $qm;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @param QueryManager $qm
     * @param Cart $cart
     */
    public function __construct(QueryManager $qm, Cart $cart)
    {
        $this->qm = $qm;
        $this->cart = $cart;
    }

    /**
     * Render the cart page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $this->server = (int)$request->route('server');
        $server = $this->qm->serverOrFail($this->server, ['id', 'name']);
        $servers = $this->qm->listOfEnabledServers(['id', 'name']);
        $products = [];
        $cost = 0;

        foreach ($this->cart->getAll($server->id) as $key => $value) {
            $product = $this->qm->product($key);
            $products[] = $product;
            $cost += $product[0]->price;
        }

        $data = [
            'cart' => $this->cart,
            'productsCollection' => $products,
            'cost' => $cost
        ];

        return view('shop.cart', $data);
    }

    /**
     * Sets the number of goods in a cart, create new payment and send the user redirect to the payment page data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pay(Request $request)
    {
        $this->server = (int)$request->route('server');
        $goods = $request->get('goods');
        $username = $request->get('username');
        $server = $this->qm->serverOrFail($this->server, ['id', 'name']);

        foreach ($goods as $one) {
            $product = $this->qm->product($one['id']);

            // Check on valid product id
            if ($product->count() === 0) {
                return json_response('invalid product id');
            }

            // Check on valid stacks count
            if ($one['count'] % $product[0]->stack !== 0) {
                return json_response('invalid count');
            }

            $this->cart->setCount($this->server, $one['id'], $one['count'] / $product[0]->stack);
        }

        $productsAndCost = $this->getProductsAndCost();
        $products = $productsAndCost['products'];
        $cost = $productsAndCost['cost'];
        $user = $this->getUsernameOrId($username);
        $user_id = null;
        $username = null;
        if (is_int($user)) {
            $user_id = $user;
        }else{
            $username = $user;
        }

        $payment = $this->qm->newPayment(null, $products, $cost, $user_id, $username, $this->server, $request->ip());

        return json_response(
            'success',
            [
                'redirect' => route('payment.cart', [
                    'server' => $server,
                    'payment' => $payment
                ])
            ]
        );
    }

    private function getProductsAndCost()
    {
        $cost = 0;
        $storage = [];
        $fromCart = $this->cart->getAll($this->server);
        foreach ($fromCart as $key => $value) {
            $product = $this->qm->product($key)[0];
            $storage[$key] = $this->cart->getCount($this->server, $key);
            $cost += $product->price * $storage[$key];
        }

        return [
            'products' => serialize($storage),
            'cost' => $cost
        ];
    }

    private function getUsernameOrId($username)
    {
        if (is_auth()) {
            return (int)\Sentinel::getUser()->getUserId();
        }

        return (string)$username;
    }

    /**
     * Put item in cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function put(Request $request)
    {
        $server = $request->route('server');
        $product = $request->route('product');

        if ($this->cart->isFull($server)) {
            return json_response('cart is full');
        }
        if ($this->cart->has($server, $product)) {
            return json_response('already in cart');
        }
        $this->cart->put($server, $product);

        return json_response('success');
    }

    /**
     * Remove item from cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(Request $request)
    {
        $server = $request->route('server');
        $product = $request->route('product');

        if ($this->cart->has($server, $product)) {
            $this->cart->remove($server, $product);

            return json_response('success');
        }

        return json_response('product not found');
    }
}
