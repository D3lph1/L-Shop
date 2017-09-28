<?php
declare(strict_types = 1);

namespace App\Exceptions\User;

use App\Exceptions\LogicException;
use Throwable;

/**
 * Class UsernameAlreadyExistsException
 * A user with this username already exists.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\User
 */
class UsernameAlreadyExistsException extends LogicException
{
    public function __construct(string $username, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("User with username `$username` already exists", $code, $previous);
    }
}
