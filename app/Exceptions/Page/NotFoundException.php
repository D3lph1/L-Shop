<?php
declare(strict_types = 1);

namespace App\Exceptions\Page;

use App\Exceptions\LShopException;
use RuntimeException;
use Throwable;

class NotFoundException extends RuntimeException implements LShopException
{
    public function __construct(int $pageId, $code = 0, Throwable $previous = null)
    {
        parent::__construct("Product with id `$pageId` not found", $code, $previous);
    }
}
