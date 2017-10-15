<?php
declare(strict_types = 1);

namespace App\Services\User\Permissions;

use App\Models\Role\RoleInterface;

abstract class Permissions
{
    /**
     * @var array|null
     */
    protected $specifiedPermissions;

    /**
     * @var RoleInterface[]
     */
    protected $roles;

    abstract public function addPermission(string $name, $value): void;

    abstract public function deletePermission(string $name): void;

    public function hasAccess(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->check($permission)) {
                return false;
            }
        }

        return true;
    }

    public function hasAnyAccess(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->check($permission)) {
                return true;
            }
        }

        return false;
    }

    private function check(string $permission): bool
    {
        foreach ($this->specifiedPermissions as $key => $value) {
            if ((str_is($permission, $key) || str_is($key, $permission)) && $value === true) {
                return true;
            }
        }

        foreach ($this->roles as $role) {
            foreach ($role->getPermissions() as $key => $value) {
                if ((str_is($permission, $key) || str_is($key, $permission)) && $value === true) {
                    return true;
                }
            }
        }

        return false;
    }
}
