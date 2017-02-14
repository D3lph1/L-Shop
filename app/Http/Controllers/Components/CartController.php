<?php

namespace App\Http\Controllers\Components;

use App\Services\Cart;
use App\Services\QueryManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * @var QueryManager
     */
    private $qm;

    /**
     * @var Cart
     */
    private $cart;

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
        $id = (int)$request->route('server');
        $server = $this->qm->serverOrFail($id, ['id', 'name']);
        $servers = $this->qm->listOfEnabledServers(['id', 'name']);
        $products = [];
        $cost = 0;

        foreach ($this->cart->getAll($server->id) as $key => $value) {
            $product = $this->qm->product($key);
            $products[] = $product;
            $cost += $product[0]->price;
        }

        $data = [
            'currentServer' => $server,
            'servers' => $servers,

            'cart' => $this->cart,
            'productsCollection' => $products,
            'cost' => $cost
        ];

        return view('shop.cart', $data);
    }

    /**
     * Sets the number of goods in a cart, and send the user redirect to the payment page data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pay(Request $request)
    {
        $id = (int)$request->route('server');
        $goods = $request->get('goods');
        $server = $this->qm->serverOrFail($id, ['id', 'name']);
        $servers = $this->qm->listOfEnabledServers(['id', 'name']);

        foreach ($goods as $one) {
            $product = $this->qm->product($one['id']);

            // Check on valid product id
            if ($product->count() === 0) {
                return response()->json(['status' => 'invalid product id']);
            }

            // Check on valid stacks count
            if ($one['count'] % $product[0]->stack !== 0) {
                return response()->json(['status' => 'invalid count']);
            }

            $this->cart->setCount($id, $one['id'], $one['count'] / $product[0]->stack);
        }

        return response()->json([
            'status' => 'success',
            'redirect' => route('payment.cart', ['server' => $server])
        ]);
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
            return response()->json(['status' => 'cart is full']);
        }
        if ($this->cart->has($server, $product)) {
            return response()->json(['status' => 'already in cart']);
        }
        $this->cart->put($server, $product);

        return response()->json(['status' => 'success']);
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

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'product not found']);
    }
}
