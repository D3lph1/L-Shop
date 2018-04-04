<?php
declare(strict_types = 1);

namespace App\Services\Product;

use App\Entity\Product;

class Cost
{
    public static function calculate(int $amount, Product $product): float
    {
        if (Stack::isForever($product)) {
            return $product->getPrice();
        }

        return ($amount / $product->getStack()) * $product->getPrice();
    }
}
