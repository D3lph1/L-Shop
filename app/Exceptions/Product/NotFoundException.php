<?php
declare(strict_types = 1);

namespace App\Exceptions\Product;

use App\Exceptions\LShopException;
use RuntimeException;
use Throwable;

class NotFoundException extends RuntimeException implements LShopException
{
    public function __construct(int $productId, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Product with id `$productId` not found", $code, $previous);
    }
}
