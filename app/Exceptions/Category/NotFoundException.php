<?php
declare(strict_types = 1);

namespace App\Exceptions\Category;

use App\Exceptions\LShopException;
use Throwable;

class NotFoundException extends \RuntimeException implements LShopException
{
    public function __construct(int $categoryId, $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            "Category with id `$categoryId` not found",
            $code,
            $previous);
    }
}
