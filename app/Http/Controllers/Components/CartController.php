<?php

namespace App\Http\Controllers\Components;

use App\Services\Cart;
use App\Services\QueryManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class CartController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
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
     * @param Cart         $cart
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
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $this->server = (int)$request->route('server');
        $server = $request->get('currentServer');
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
     * To perform all the necessary checks and, if the user has sufficient funds to make
     * payments otherwise redirects the user to select a payment aggregator page.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function pay(Request $request)
    {
        $this->server = (int)$request->route('server');
        $goods = $request->get('goods');
        $this->qm->serverOrFail($this->server, ['id', 'name']);

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

        $result = $this->buildPayment($request);

        if ($result['quick']) {
            // If the user has enough money in the account to make quick payment
            if (is_int($result['result'])) {
                $this->cart->clear($this->server);
                return json_response(
                    'success',
                    [
                        'quick' => true,    // A sign that the payment is a "quick"
                        'new_balance' => \Sentinel::getUser()->getBalance()     // New user balance for replace old balance by JavaScript
                    ]
                );
            }
        }

        // If the user does not have enough money in the account, redirect it to the page select a payment aggregator
        if (is_int($result['result'])) {
            \App::make('msg')->info('На вашем счете недостаточно средств для совершения покупки.
                Вы можете оплатить покупку любым удобным для вас способом прямо сейчас.');
            return json_response(
                'success',
                [
                    'quick' => false,   // A sign that the payment is not a "quick"
                    // Redirect link
                    'redirect' => route('payment.cart', [
                        'server' => $this->server,
                        'payment' => $result['result']
                    ])
                ]
            );
        }

        return json_response('failed');
    }

    /**
     * Collect data for create new payment
     *
     * @param Request $request
     *
     * @return array
     */
    private function buildPayment(Request $request)
    {
        $productsAndCost = $this->getProductsAndCost();
        $products = $productsAndCost['products'];
        $cost = $productsAndCost['cost'];
        try {
            $user = $this->getUsernameOrId($request->get('username'));
        } catch (\UnexpectedValueException $e) {
            return json_response('invalid username');
        }
        $user_id = null;
        $username = null;
        if (is_int($user)) {
            $user_id = $user;
            $balance = \Sentinel::getUser()->getBalance() - $cost;
            // If the user has enough money in the account to make quick payment
            if ($balance >= 0) {
                // Update user balance
                \Sentinel::update(\Sentinel::getUser(), [
                    'balance' => $balance
                ]);

                return [
                    'quick' => true,    // A sign that the payment is a "quick"
                    'result' => // Stores payment identifier in the case of successful query
                        $this->qm->newPayment(null, $products, $cost, $user_id, null, $this->server, $request->ip(), true)
                ];
            }
        } else {
            $username = $user;
        }

        return [
            'quick' => false,   // A sign that the payment is not a "quick"

            'result' => // Stores payment identifier in the case of successful query
                $this->qm->newPayment(null, $products, $cost, $user_id, $username, $this->server, $request->ip())
        ];
    }

    /**
     * Get products data [id => count] (in serialized form) and total products cost for payment
     *
     * @return array
     */
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

    /**
     * Return the user name or ID, depending on whether there is a payment from an authorized user or not
     *
     * @param $username
     *
     * @return int|string
     */
    private function getUsernameOrId($username)
    {
        if (is_auth()) {
            return (int)\Sentinel::getUser()->getUserId();
        }

        // If user not auth
        if (mb_strlen($username) > 3) {
            return (string)$username;
        }

        throw new \UnexpectedValueException('username is short');
    }

    /**
     * Put item in cart
     *
     * @param Request $request
     *
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
     *
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
