<?php
declare(strict_types = 1);

namespace App\Exceptions\User;

use App\Exceptions\LogicException;
use Throwable;

/**
 * Class EmailAlreadyExistsException
 * A user with this email already exists.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\User
 */
class EmailAlreadyExistsException extends LogicException
{
    public function __construct(string $email, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("User with email `$email` already exists", $code, $previous);
    }
}
