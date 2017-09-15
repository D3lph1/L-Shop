<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Shop;

use App\Exceptions\Payment\InvalidProductsCountException;
use App\Exceptions\User\InvalidUsernameException;
use App\Http\Controllers\Controller;
use App\Services\Cart;
use App\Traits\BuyResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class CartController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Components
 */
class CartController extends Controller
{
    use BuyResponse;

    /**
     * @var Cart
     */
    private $cart;

    public function __construct()
    {
        parent::__construct();
        $this->cart = $this->app->make('cart');
    }

    /**
     * Render the cart page.
     */
    public function render(\App\TransactionScripts\Shop\Cart $cart): View
    {
        $products = $cart->products();
        $cost = $cart->cost($products);

        $data = [
            'products' => $products,
            'cost' => $cost,
            'cart' => $this->cart
        ];

        return view('shop.cart', $data);
    }

    public function buy(Request $request, \App\TransactionScripts\Shop\Cart $cart): JsonResponse
    {
        $server = (int)$request->route('server');
        $ip = $request->ip();
        $username = $request->get('username');
        $products = $request->get('products');

        try {
            return $cart->purchase($products, $server, $ip, $username);
        } catch (InvalidUsernameException $e) {
            return json_response('invalid_username', [
                'message' => [
                    'type' => 'danger',
                    'text' => __('messages.shop.catalog.buy.invalid_username')
                ]
            ]);
        } catch (InvalidProductsCountException $e) {
            return json_response('invalid_products_count', [
                'message' => [
                    'type' => 'danger',
                    'text' => __('messages.shop.catalog.buy.invalid_count')
                ]
            ]);
        }
    }

    /**
     * Put item in cart.
     */
    public function put(Request $request): JsonResponse
    {
        $product = (int)$request->route('product');

        if ($this->cart->isFull()) {
            return json_response('cart_is_full', [
                'message' => [
                    'type' => 'warning',
                    'text' => __('messages.shop.cart.full'),
                ]
            ]);
        }

        if ($this->cart->has($product)) {
            return json_response('already_in_cart', [
                'message' => [
                    'type' => 'warning',
                    'text' => __('messages.shop.cart.already_in'),
                ]
            ]);
        }

        $this->cart->put($product);

        return json_response('success', [
            'message' => [
                'type' => 'success',
                'text' => __('messages.shop.cart.success.message')
            ],
            'button' => __('messages.shop.cart.success.btn')
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request): JsonResponse
    {
        $product = (int)$request->route('product');

        if ($this->cart->has($product)) {
            $this->cart->remove($product);

            return json_response('success', [
                'message' => [
                    'type' => 'info',
                    'text' => __('messages.shop.cart.remove.success')
                ]
            ]);
        }

        return json_response('fail', [
            'message' => [
                'type' => 'danger',
                'text' => __('messages.shop.cart.remove.fail')
            ]
        ]);
    }
}
