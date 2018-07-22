<?php
declare(strict_types = 1);

namespace App\Exceptions\Role;

use App\Exceptions\LogicException;
use Throwable;

class RoleAlreadyExistsException extends LogicException
{
    /**
     * @var mixed
     */
    private $cause;

    public function __construct(string $message = "", $cause)
    {
        parent::__construct($message, 0, null);
        $this->cause = $cause;
    }

    public static function withName(string $name)
    {
        return new RoleAlreadyExistsException("Role with name \"$name\" already exists", $name);
    }

    /**
     * @return mixed
     */
    public function getCause()
    {
        return $this->cause;
    }
}
