<?php

namespace App\Services;

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
    public function count($server)
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
        return $this->count($server) === 0 ? true : false;
    }

    /**
     * @param int|string $server
     * @return bool
     */
    public function isFull($server)
    {
        if ($this->count($server) >= s_get('cart.capacity', 12)) {
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
