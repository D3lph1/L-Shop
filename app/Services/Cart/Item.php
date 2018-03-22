<?php
declare(strict_types = 1);

namespace App\Services\Cart;

use App\Entity\Product;

/**
 * Class Item
 * Represents a shopping cart storage unit.
 */
class Item
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $amount;

    public function __construct(Product $product, int $amount)
    {
        $this->product = $product;
        $this->amount = $amount;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
