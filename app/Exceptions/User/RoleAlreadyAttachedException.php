<?php
declare(strict_types = 1);

namespace App\Exceptions\User;

use App\Exceptions\LogicException;

class RoleAlreadyAttachedException extends LogicException
{
    /**
     * @var mixed
     */
    private $role;

    public function __construct(string $message, $role)
    {
        parent::__construct($message);
        $this->role = $role;
    }

    public static function withName(string $name): RoleAlreadyAttachedException
    {
        return new RoleAlreadyAttachedException("Role with name `$name` already attached", $name);
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }
}
