<?php
declare(strict_types = 1);

namespace App\Services\Auth\Acl;

trait RoleTrait
{
    public function hasRole(string $role): bool
    {
        /** @var RoleInterface $each */
        foreach ($this->getRoles() as $each) {
            if ($role === $each->getName()) {
                return true;
            }
        }

        return false;
    }

    public function hasAllRoles(iterable $roles): bool
    {
        /** @var PermissionInterface $each */
        foreach ($this->getRoles() as $each) {
            /** @var RoleInterface $role */
            foreach ($roles as $role) {
                if ($role->getName() !== $each->getName()) {
                    return false;
                }
            }
        }

        return true;
    }

    public function hasAtLeastOneRole(iterable $roles): bool
    {
        /** @var PermissionInterface $each */
        foreach ($this->getRoles() as $each) {
            /** @var RoleInterface $role */
            foreach ($roles as $role) {
                if ($role->getName() === $each->getName()) {
                    return true;
                }
            }
        }

        return false;
    }
}
