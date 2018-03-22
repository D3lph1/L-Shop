<?php
declare(strict_types=1);

namespace App\Services\Auth\Acl;

trait PermissionTrait
{
    /**
     * {@inheritdoc}
     */
    public function hasPermission($permission): bool
    {
        /** @var PermissionInterface $each */
        foreach ($this->getPermissions() as $each) {
            if ($permission instanceof PermissionInterface) {
                if ($permission->getName() === $each->getName()) {
                    return true;
                }
            } else {
                if ($permission === $each->getName()) {
                    return true;
                }
            }
        }
        if ($this instanceof HasRoles) {
            /** @var RoleInterface $each */
            foreach ($this->getRoles() as $each) {
                if ($each->hasPermission($permission)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function hasAllPermissions(array $permissions): bool
    {
        /** @var PermissionInterface $each */
        foreach ($this->getPermissions() as $each) {
            foreach ($permissions as $permission) {
                if ($permission instanceof PermissionInterface) {
                    if ($permission->getName() !== $each->getName()) {
                        return false;
                    }
                } else {
                    if ($permission !== $each->getName()) {
                        return false;
                    }
                }
            }
        }

        if ($this instanceof HasRoles) {
            foreach ($this->getRoles() as $role) {
                foreach ($permissions as $permission) {
                    if (!$role->hasPermission($permission)) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function hasAtLeastOnePermission(array $permissions): bool
    {
        /** @var PermissionInterface $each */
        foreach ($this->getPermissions() as $each) {
            foreach ($permissions as $permission) {
                if ($permission instanceof PermissionInterface) {
                    if ($permission->getName() === $each->getName()) {
                        return true;
                    }
                } else {
                    if ($permission === $each->getName()) {
                        return true;
                    }
                }
            }
        }

        if ($this instanceof HasRoles) {
            foreach ($this->getRoles() as $role) {
                foreach ($permissions as $permission) {
                    if ($role->hasPermission($permission)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
