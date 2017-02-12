<?php

namespace App\Http\Controllers\Components;

use App\Services\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * Render the cart page
     *
     * @param Request $request
     * @param Cart $cart
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request, Cart $cart)
    {
        $id = (int)$request->route('server');
        $qm = \App::make('qm');
        $server = $qm->serverOrFail($id, ['id', 'name']);
        $servers = $qm->listOfEnabledServers(['id', 'name']);
        $products = [];
        $cost = 0;

        foreach ($cart->getAll($server->id) as $key => $value) {
            $product = $qm->product($key);;
            $products[] = $product;
            $cost += $product[0]->price;
        }

        $data = [
            'currentServer' => $server,
            'servers' => $servers,

            'cart' => $cart,
            'productsCollection' => $products,
            'cost' => $cost
        ];

        return view('shop.cart', $data);
    }

    /**
     * Put item in cart
     *
     * @param Request $request
     * @param Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function put(Request $request, Cart $cart)
    {
        $server = $request->route('server');
        $product = $request->route('product');

        if (!$cart->has($server, $product)) {
            $cart->put($server, $product);

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'already in cart']);
    }

    /**
     * Remove item from cart
     *
     * @param Request $request
     * @param Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(Request $request, Cart $cart)
    {
        $server = $request->route('server');
        $product = $request->route('product');

        if ($cart->has($server, $product)) {
            $cart->remove($server, $product);

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'product not found']);
    }
}
