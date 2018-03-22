<?php
declare(strict_types = 1);

namespace App\Services\Auth\Acl;

trait RoleTrait
{
    /**
     * {@inheritdoc}
     */
    public function hasRole($role): bool
    {
        /** @var RoleInterface $each */
        foreach ($this->getRoles() as $each) {
            if ($each instanceof RoleInterface) {
                if ($role->getName() === $each->getName()) {
                    return true;
                }
            } else {
                if ($role === $each->getName()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function hasAllRoles(array $roles): bool
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

    /**
     * {@inheritdoc}
     */
    public function hasAtLeastOneRole(array $roles): bool
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
