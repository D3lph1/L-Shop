<?php
declare(strict_types = 1);

namespace App\Exceptions\User;

use App\Entity\Role;
use App\Exceptions\LogicException;
use Throwable;

class RoleAlreadyAttachedException extends LogicException
{
    /**
     * @var Role
     */
    private $role;

    public function __construct(Role $role, int $code = 0, Throwable $previous = null)
    {
        $this->role = $role;
        parent::__construct("Role {$role} already exists", $code, $previous);
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }
}
