<?php
declare(strict_types=1);

namespace App\Services\Auth\Acl;

use Doctrine\Common\Collections\Collection;

/**
 * Trait PermissionTrait
 * Represents functionality for checking for permissions.
 */
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
            foreach ($permissions as $key => &$permission) {
                if ($permission instanceof PermissionInterface) {
                    if ($permission->getName() === $each->getName()) {
                        unset($permissions[$key]);
                    }
                } else {
                    if ($permission === $each->getName()) {
                        unset($permissions[$key]);
                    }
                }
            }
        }

        if ($this instanceof HasRoles) {
            foreach ($this->getRoles() as $role) {
                foreach ($permissions as $key => &$permission) {
                    if ($role->hasPermission($permission)) {
                        unset($permissions[$key]);
                    }
                }
            }
        }

        return count($permissions) === 0;
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

    /**
     * @return Collection
     */
    abstract public function getPermissions(): Collection;
}
