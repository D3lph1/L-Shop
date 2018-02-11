<?php
declare(strict_types = 1);

namespace App\Services\Auth\Acl;

trait PermissionTrait
{
    public function hasPermission(string $permission): bool
    {
        /** @var PermissionInterface $each */
        foreach ($this->getPermissions() as $each) {
            if ($permission === $each->getName()) {
                return true;
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

    public function hasAllPermission(iterable $permissions): bool
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
            /** @var RoleInterface $each */
            foreach ($this->getRoles() as $each) {
                foreach ($permissions as $permission) {
                    if ($permission instanceof PermissionInterface) {
                        if (!$this->hasPermission($permission->getName())) {
                            return false;
                        }
                    } else {
                        if (!$this->hasPermission($permission)) {
                            return false;
                        }
                    }
                }
            }
        }

        return true;
    }

    public function hasAtLeastOnePermission(iterable $permissions): bool
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
            /** @var PermissionInterface $each */
            foreach ($this->getPermissions() as $each) {
                foreach ($permissions as $permission) {
                    if ($permission instanceof PermissionInterface) {
                        if ($this->hasPermission($permission->getName())) {
                            return true;
                        }
                    } else {
                        if ($this->hasPermission($permission)) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }
}
