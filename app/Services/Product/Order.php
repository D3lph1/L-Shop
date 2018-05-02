<?php
declare(strict_types = 1);

namespace App\Services\Product;

class Order
{
    /**
     * Private constructor because this class contains only static methods.
     */
    private function __construct()
    {
    }

    /**
     * Returns an array with fields for which sorting is allowed.
     *
     * @return string[]
     */
    public static function availableFields(): array
    {
        return ['product.sortPriority', 'item.name'];
    }
}
