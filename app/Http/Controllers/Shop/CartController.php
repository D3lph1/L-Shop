<?php

namespace App\Http\Controllers\Shop;

use App\Exceptions\Payment\InvalidProductsCountException;
use App\Exceptions\User\InvalidUsernameException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\BuyResponse;
use App\Services\CartBuy;

/**
 * Class CartController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Components
 */
class CartController extends Controller
{
    use BuyResponse;

    /**
     * @var array
     */
    private $productsId = [];

    /**
     * @var array
     */
    private $productsCount = [];

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
        $products = [];
        $cost = 0;
        $fromCart = $this->cart->products();
        if ($fromCart) {
            $ids = array_keys($fromCart);
            $products = $this->qm->product(
                $ids,
                ['products.id as id', 'items.name', 'items.image', 'products.price', 'products.stack']
            );
            foreach ($products as $product) {
                $cost += $product->price;
            }
        }
        $data = [
            'cart' => $this->cart,
            'products' => $products,
            'cost' => $cost
        ];

        return view('shop.cart', $data);
    }

    /**
     * @param Request $request
     * @param CartBuy $handler
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(Request $request, CartBuy $handler)
    {
        $server = (int)$request->route('server');
        $ip = $request->ip();
        $username = $request->get('username');
        $products = $request->get('products');

        try {
            return $handler->buy($products, $this->cart, $server, $ip, $username);
        } catch (InvalidUsernameException $e) {
            return json_response('invalid username');
        } catch (InvalidProductsCountException $e) {
            return json_response('invalid products count');
        }
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
        $product = (int)$request->route('product');

        if ($this->cart->isFull()) {
            return json_response('cart is full');
        }

        if ($this->cart->has($product)) {
            return json_response('already in cart');
        }

        $this->cart->put($product);

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
        $product = (int)$request->route('product');

        if ($this->cart->has($product)) {
            $this->cart->remove($product);

            return json_response('success');
        }

        return json_response('product not found');
    }
}
