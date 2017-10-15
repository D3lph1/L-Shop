<?php
declare(strict_types = 1);

namespace App\Exceptions\User;

use App\Exceptions\LogicException;
use Throwable;

/**
 * Class AlreadyActivatedException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\User
 */
class AlreadyActivatedException extends LogicException
{
    public function __construct(int $userId, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("User with id `$userId` already activated", $code, $previous);
    }
}
