<?php
declare(strict_types = 1);

namespace App\Exceptions\User;

use App\Entity\Role;
use App\Exceptions\LogicException;

class RoleAlreadyAttachedException extends LogicException
{
    /**
     * @var Role
     */
    private $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
        parent::__construct("Role {$role} already exists", 0, null);
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }
}
