<?php
declare(strict_types = 1);

namespace App\Exceptions\Product;

use App\Exceptions\DomainException;

class DoesNotExistException extends DomainException
{
    public function __construct($product)
    {
        parent::__construct("Product {$product} does not exist", 0, null);
    }
}
