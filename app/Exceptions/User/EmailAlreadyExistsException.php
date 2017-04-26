<?php

namespace App\Exceptions\User;

use Symfony\Component\Console\Exception\LogicException;

/**
 * Class EmailAlreadyExistsException
 * A user with this email already exists.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Exceptions\User
 */
class EmailAlreadyExistsException extends LogicException
{
    //
}
