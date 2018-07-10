<?php
declare(strict_types = 1);

namespace App\Exceptions\Role;

use App\Exceptions\DomainException;

class RoleNotFoundException extends DomainException
{
    /**
     * @var mixed|null
     */
    private $cause;

    public function __construct(string $message = "", $cause = null)
    {
        parent::__construct($message);
        $this->cause = $cause;
    }

    public static function byName(string $name): PermissionNotFoundException
    {
        return new PermissionNotFoundException("Role with name \"{$name}\" not found", $name);
    }

    /**
     * @return mixed|null
     */
    public function getCause()
    {
        return $this->cause;
    }
}
