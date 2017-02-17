<?php

namespace App\Http\Controllers\Shop;

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
        $products = $request->get('products');
        $this->qm->serverOrFail($this->server, ['id', 'name']);
        $manager = \App::make('payment.manager.cart');

        $putResult = $this->putCount($products);
        if ($putResult !== true) {
            return $putResult;
        }

        return $manager->handle($request);
    }

    /**
     * Put information on the number of products in the cart
     *
     * @param $products
     *
     * @return bool|\Illuminate\Http\JsonResponse
     */
    private function putCount($products)
    {
        foreach ($products as $one) {
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

        return true;
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
