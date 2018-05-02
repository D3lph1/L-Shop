<?php
declare(strict_types = 1);

namespace App\Services\Product;

use App\Entity\Product;

class Cost
{
    /**
     * Private constructor because this class contains only static methods.
     */
    private function __construct()
    {
    }

    public static function calculate(int $amount, Product $product): float
    {
        if (Stack::isForever($product)) {
            return $product->getPrice();
        }

        return ($amount / $product->getStack()) * $product->getPrice();
    }
}
