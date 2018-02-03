<?php
declare(strict_types = 1);

namespace App\Services\Cart;

use App\Entity\Product;

class Item
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var float
     */
    private $amount;

    public function __construct(Product $product, float $amount)
    {
        $this->product = $product;
        $this->amount = $amount;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
