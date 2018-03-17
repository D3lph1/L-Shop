<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Users\Edit;

use App\DataTransferObjects\Admin\Users\Edit\User as UserDTO;
use App\Entity\Permission;
use App\Entity\Role;

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

    public function setUser(UserDTO $user): RenderResult
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return UserDTO
     */
    public function getUser(): UserDTO
    {
        return $this->user;
    }

    /**
     * @param Role[] $roles
     *
     * @return RenderResult
     */
    public function setRoles(array $roles): RenderResult
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Role[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param Permission[] $permissions
     *
     * @return RenderResult
     */
    public function setPermissions(array $permissions): RenderResult
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * @return Permission[]
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }
}
