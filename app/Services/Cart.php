<?php

namespace App\Services;

/**
 * Class Cart
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Cart
{
    /**
     * Put product in a cart
     *
     * @param int|string $server
     * @param $product
     */
    public function put($server, $product)
    {
        if (!$this->has($server, $product)) {
            \Session::push("cart.$server.$product", 1);
            $this->setCount($server, $product, 1);
        }
    }

    /**
     * Get property value of product in cart
     *
     * @param int|string $server
     * @param int|string $product
     * @param int|string $property
     * @return mixed|null
     */
    public function get($server, $product, $property)
    {
        if ($this->has($server, $product)) {
            return \Session::get("cart.$server.$product.$property");
        }

        return null;
    }

    /**
     * Set product in cart stacks count
     *
     * @param int|string $server
     * @param int|string $product
     * @param int $count
     */
    public function setCount($server, $product, $count)
    {
        if ($this->has($server, $product)) {
            \Session::put("cart.$server.$product.count", $count);
        }
    }

    /**
     * Get count of current products in cart
     *
     * @param $server
     * @param $product
     * @return int
     */
    public function getCount($server, $product)
    {
        if ($this->has($server, $product)) {
            return (int)\Session::get("cart.$server.$product.count");
        }

        return 0;
    }

    /**
     * Check product on existing in a cart
     *
     * @param int|string $server
     * @param int|string $product
     * @return bool
     */
    public function has($server, $product)
    {
        if (\Session::has("cart.$server.$product")) {
            return true;
        }

        return false;
    }

    /**
     * Get all products from cart by server id
     *
     * @param int|string $server
     * @return array
     */
    public function getAll($server)
    {
        if (\Session::has("cart.$server")) {
            return \Session::get("cart.$server");
        }

        return [];
    }

    /**
     * Get count of goods in cart
     *
     * @param int|string $server
     * @return int
     */
    public function productsCount($server)
    {
        return count(\Session::get("cart.$server"));
    }

    /**
     * Return true if cart was empty
     *
     * @param int|string $server
     * @return bool
     */
    public function isEmpty($server)
    {
        return $this->productsCount($server) === 0 ? true : false;
    }

    /**
     * @param int|string $server
     * @return bool
     */
    public function isFull($server)
    {
        if ($this->productsCount($server) >= s_get('cart.capacity', 12)) {
            return true;
        }

        return false;
    }

    /**
     * Remove product from a cart
     *
     * @param int|string $server
     * @param int|string $product
     */
    public function remove($server, $product)
    {
        if ($this->has($server, $product)) {
            \Session::forget("cart.$server.$product");
        }
    }
}
