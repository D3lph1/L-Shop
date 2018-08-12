<?php
declare(strict_types = 1);

namespace App\Services\Product;

use App\Entity\Product;
use App\Services\Item\Type;

/**
 * Class Cost
 * Encapsulates the logic of work with the value of products.
 */
class Cost
{
    /**
     * Private constructor because this class contains only static methods.
     */
    private function __construct()
    {
    }

    /**
     * Calculates the cost of products.
     *
     * @param Product $product
     * @param int     $amount
     *
     * @return float
     */
    public static function calculate(Product $product, int $amount): float
    {
        $type = $product->getItem()->getType();
        if ($type === Type::PERMGROUP) {
            if (Stack::isForever($product)) {
                return $product->getPrice();
            }
        }

        if ($type === Type::REGION_OWNER || $type === Type::REGION_MEMBER || $type === Type::COMMAND) {
            return $product->getPrice();
        }

        return ($amount / $product->getStack()) * $product->getPrice();
    }
}
