<?php
declare(strict_types = 1);

namespace App\Exceptions\User;

use App\Exceptions\LShopException;
use LogicException;

class AttemptToDeleteYourselfException extends LogicException implements LShopException
{
    //
}
