<?php
declare(strict_types = 1);

namespace App\Services\Product;

class Order
{
    public static function availableFields()
    {
        return ['product.sortPriority', 'item.name'];
    }
}
