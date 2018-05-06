<?php
declare(strict_types = 1);

namespace App\Services\Auth\Acl;

use Doctrine\Common\Collections\Collection;

/**
 * Interface HasRoles
 * Represents entities that can have roles.
 */
interface HasRoles
{
    /**
     * Checks whether the user has a passed role.
     *
     * @param string|RoleInterface $role Role name or role object.
     *
     * @return bool True - the user has a role.
     */
    public function hasRole($role): bool;

    /**
     * Checks if the user has all of the specified roles.
     *
     * @param string[]|RoleInterface[] $roles Array with role names or role objects.
     *
     * @return bool True - the user has all roles.
     */
    public function hasAllRoles(array $roles): bool;

    /**
     * Checks if the user has at least one of the passed roles.
     *
     * @param string[]|RoleInterface[] $roles Array with role names or role objects.
     *
     * @return bool True - the user has at least one role.
     */
    public function hasAtLeastOneRole(array $roles): bool;

    /**
     * Returns the roles that belong to an entity.
     *
     * @return Collection
     */
    public function getRoles(): Collection;
}
