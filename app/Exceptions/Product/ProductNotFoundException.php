<?php
declare(strict_types = 1);

namespace App\Exceptions\Product;

use App\Exceptions\DomainException;

class ProductNotFoundException extends DomainException
{
    public static function byId(int $id): ProductNotFoundException
    {
        return new ProductNotFoundException("Product with id {$id} not found");
    }
}
