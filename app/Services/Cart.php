<?php

namespace App\Services;

use App\Exceptions\CartException;
use App\Exceptions\InvalidArgumentTypeException;

/**
 * Class Cart
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Cart
{
    /**
     * Name of cart - array in session.
     *
     * @var string
     */
    private $name = 'cart';

    /**
     * Server identifier.
     *
     * @var int
     */
    private $server;

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->server = \Request::route('server');

        if (!\Session::has('cart')) {
            $this->createNewSection($this->server);
        }
    }

    /**
     * Put the products in cart
     *
     * @param int   $product    Product identify
     * @param int   $count      Product count
     * @param array $attributes Optional attributes
     */
    public function put($product, $count = 1, array $attributes = [])
    {
        $this->checkType($product);
        $this->checkType($count);

        $data = array_merge($attributes, [
            'count' => $count
        ]);

        \Session::put($this->getProductSectionName($product), $data);
    }

    /**
     * @param int $product Product identifier.
     * @param int $count   Product count.
     */
    public function setProductCount($product, $count)
    {
        $this->checkType($product);
        $this->checkType($count);

        \Session::put($this->getProductSectionName($product), ['count' => $count]);
    }

    /**
     * Get given product from cart.
     *
     * @param int $product Product identifier.
     *
     * @throws CartException
     *
     * @return array
     */
    public function get($product)
    {
        $this->checkType($product);

        if ($this->has($product)) {
            return \Session::get($this->getProductSectionName($product));
        }

        throw new CartException("Product with id `$product` (server `{$this->server}`) not found");
    }

    /**
     * Get given product from cart. Unlike App\Services\Cart::get this method will
     * throw an exception if product does not exists in cart.
     *
     * @deprecated It deprecated as it does not throw an CartException when product not found.
     *
     * @param int $product Product identifier.
     *
     * @return array
     */
    public function getSilent($product)
    {
        $this->checkType($product);

        return \Session::get($this->getProductSectionName($product));
    }

    /**
     * Get attribute `count` value of given product.
     *
     * @param int $product Product identifier.
     *
     * @return int
     */
    public function productCount($product)
    {
        return $this->get($product)['count'];
    }

    /**
     * Calculate and return count of all products in cart for current server.
     *
     * @return int
     */
    public function productsCount()
    {
        return count(\Session::get($this->getServerSectionName()));
    }

    /**
     * Get value of given product attribute such as `count`.
     *
     * @param int   $product Product identify.
     * @param mixed $attribute
     */
    public function attribute($product, $attribute)
    {
        $this->get($product)[$attribute];
    }

    /**
     * Get all products from cart of current server.
     *
     * @return array|null
     */
    public function products()
    {
        return \Session::get($this->getServerSectionName());
    }

    /**
     * @return array
     */
    public function getIdentifiersAsArray()
    {
        return array_keys($this->products());
    }

    /**
     * @return array
     */
    public function getCountAsArray()
    {
        $products = $this->products();
        $result = [];

        foreach ($products as $product) {
            $result[] = $product['count'];
        }

        return $result;
    }

    /**
     * @param int $product Product identify.
     *
     * @return bool
     */
    public function has($product)
    {
        $this->checkType($product);

        return \Session::has($this->getProductSectionName($product));
    }

    /**
     * Check cart on the absence of product.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->productsCount() === 0;
    }

    /**
     * Check for completeness cart.
     *
     * @return bool
     */
    public function isFull()
    {
        return $this->productsCount() >= s_get('cart.capacity', 12);
    }

    /**
     * Remove given product from cart.
     *
     * @param int $product Product identifier.
     */
    public function remove($product)
    {
        $this->checkType($product);

        \Session::forget($this->getProductSectionName($product));
    }

    /**
     * Delete all products from cart.
     */
    public function flush()
    {
        \Session::forget($this->getServerSectionName());
    }

    /**
     * @return string
     */
    private function getServerSectionName()
    {
        return "{$this->name}.{$this->server}";
    }

    /**
     * @param int $product Product identifier.
     *
     * @return string
     */
    private function getProductSectionName($product)
    {
        return $this->getServerSectionName() . ".$product";
    }

    /**
     * @param int $serverId Server identifier.
     */
    private function createNewSection($serverId)
    {
        \Session::put('cart', [$serverId => []]);
    }

    /**
     * @param mixed $target
     */
    private function checkType($target)
    {
        if (!(is_int($target))) throw new InvalidArgumentTypeException('integer', $target);
    }
}
