<?php
declare(strict_types = 1);

namespace App\Exceptions\User;

use App\Exceptions\RuntimeException;
use Throwable;

/**
 * Class NotFoundException
 * User with given credentials not found.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Exceptions\User
 */
class NotFoundException extends RuntimeException
{
    public function __construct(int $userId, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("User with id `$userId` not found", $code, $previous);
    }
}
