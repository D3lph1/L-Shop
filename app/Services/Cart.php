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
     * @param $server
     * @return int
     */
    public function count($server)
    {
        return count(\Session::get("cart.$server"));
    }

    /**
     * Return true if cart was empty
     *
     * @param $server
     * @return bool
     */
    public function isEmpty($server)
    {
        return $this->count($server) === 0 ? true : false;
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
