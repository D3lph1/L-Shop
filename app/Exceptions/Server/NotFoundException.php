<?php
declare(strict_types = 1);

namespace App\Exceptions\Server;

use App\Exceptions\LShopException;
use RuntimeException;
use Throwable;

class NotFoundException extends RuntimeException implements LShopException
{
    public function __construct(int $serverId, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Server with id `$serverId` not found", $code, $previous);
    }
}
