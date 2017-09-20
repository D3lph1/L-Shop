<?php
declare(strict_types = 1);

namespace App\Exceptions\User;

use App\Exceptions\LShopException;
use LogicException;
use Throwable;

class AlreadyActivatedException extends LogicException implements LShopException
{
    public function __construct(int $userId, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("User with id `$userId` already activated", $code, $previous);
    }
}
