<?php
declare(strict_types = 1);

namespace App\Exceptions\Product;

use App\Entity\Product;
use App\Exceptions\RuntimeException;
use Throwable;

class HiddenException extends RuntimeException
{
    public function __construct(Product $product, int $code = 0, Throwable $previous = null)
    {
        $message = "Product {$product} is hidden";

        parent::__construct($message, $code, $previous);
    }
}
