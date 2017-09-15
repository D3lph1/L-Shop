<?php
declare(strict_types = 1);

namespace App\Exceptions\Item;

use App\Exceptions\LShopException;
use RuntimeException;
use Throwable;

class NotFoundException extends RuntimeException implements LShopException
{
    public function __construct(int $itemId, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Item with id `$itemId` not found", $code, $previous);
    }
}
