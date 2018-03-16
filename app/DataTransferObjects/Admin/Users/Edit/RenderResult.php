<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Users\Edit;

use App\DataTransferObjects\Admin\Users\Edit\User as UserDTO;
use App\Entity\Permission;
use App\Entity\Role;
use App\Entity\User;

class RenderResult
{
    /**
     * @var UserDTO
     */
    private $user;

    /**
     * @var Role[]
     */
    private $roles = [];

    /**
     * @var Permission[]
     */
    private $permissions = [];

    /**
     * RenderResult constructor.
     *
     * @param \App\DataTransferObjects\Admin\Users\Edit\User $user
     * @param Role[]                                          $roles
     * @param Permission[]                                          $permissions
     */
    public function __construct(UserDTO $user, array $roles, array $permissions)
    {
        $this->user = $user;
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    /**
     * @return UserDTO
     */
    public function getUser(): UserDTO
    {
        return $this->user;
    }

    /**
     * @return Role[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return Permission[]
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }
}
