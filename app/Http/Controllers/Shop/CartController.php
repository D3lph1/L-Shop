<?php

namespace App\Http\Controllers\Shop;

use App\Exceptions\Payment\InvalidProductsCountException;
use App\Exceptions\User\InvalidUsernameException;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Services\Cart;
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
     *
     * @param ProductRepository $productRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(ProductRepository $productRepository)
    {
        $products = [];
        $cost = 0;
        $fromCart = $this->cart->products();
        if ($fromCart) {
            $ids = array_keys($fromCart);
            $products = $productRepository->getWithItems(
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
