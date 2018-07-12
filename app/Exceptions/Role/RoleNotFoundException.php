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

    public static function byId(int $id): RoleNotFoundException
    {
        return new RoleNotFoundException("Role with id {$id} not found", $id);
    }

    public static function byName(string $name): RoleNotFoundException
    {
        return new RoleNotFoundException("Role with name \"{$name}\" not found", $name);
    }

    /**
     * @return mixed|null
     */
    public function getCause()
    {
        return $this->cause;
    }
}
