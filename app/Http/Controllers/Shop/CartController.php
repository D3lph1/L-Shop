<?php

namespace App\Http\Controllers\Shop;

use App\Traits\Responsible;
use Illuminate\Http\Request;
use App\Services\Payments\Manager;
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
    use Responsible;

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
        $server = $request->get('currentServer');

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
     * @param Request      $request
     * @param Manager      $manager
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(Request $request, Manager $manager)
    {
        $distributor = \App::make('distributor');
        $server = (int)$request->route('server');
        $username = $request->get('username');

        if (!is_auth()) {
            $validated = $this->checkUsername($username, true);
            if ($validated !== true) {
                return $validated;
            }
        }

        $this->setProductsIdAndCount($request->get('products'));
        $manager
            ->setServer($server)
            ->setIp($request->ip());

        if (!is_auth() and $username) {
            $manager->setUsername($username);
        }

        $payment = null;
        \DB::transaction(function () use ($manager, $distributor, &$payment) {
            $payment = $manager->createPayment($this->productsId, $this->productsCount, Manager::COUNT_TYPE_NUMBER);
            if ($payment->complete) {
                $distributor->give($payment);
            }
            $this->cart->flush();
        });

        return $this->buildResponse($server, $payment);
    }

    private function setProductsIdAndCount($products)
    {
        foreach ($products as $product) {
            $this->productsId[] = $product['id'];
            $this->productsCount[] = $product['count'];
        }
    }

    /**
     * Put information on the number of products in the cart
     *
     * @param array $products
     *
     * @return bool|\Illuminate\Http\JsonResponse
     */
    private function putCount($products)
    {
        $ids = [];
        $count = [];
        foreach ($products as $product) {
            $ids[] = $product['id'];
            $count[] = $product['count'];
        }

        $products = $this->qm->product(
            $ids,
            [
                'products.id',
                'items.name',
                'products.price',
                'products.stack'
            ]
        );

        // Check on valid products identifiers
        if (count($ids) !== count($products)) {
            return json_response('invalid product id');
        }

        $i = 0;
        foreach ($products as $product) {
            // Check on valid stacks count
            if ($count[$i] % $product->stack !== 0) {
                return json_response('invalid count');
            }

            $this->cart->setProductCount((int)$product->id, $count[$i] / $product->stack);
            $i++;
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
        $server = $request->route('server');
        $product = (int)$request->route('product');

        if ($this->cart->has($product)) {
            $this->cart->remove($product);

            return json_response('success');
        }

        return json_response('product not found');
    }
}
