<?php
declare(strict_types = 1);

namespace App\Repository\Role;

use App\Entity\Role;

interface RoleRepository
{
    public function create(Role $role): void;

    public function findByName(string $name): ?Role;

    /**
     * @param int[] $identifiers
     *
     * @return Role[]
     */
    public function findWhereIdIn(array $identifiers): array;

    /**
     * @param string[] $names
     *
     * @return Role[]
     */
    public function findWhereNameIn(array $names): array;

    /**
     * @return Role[]
     */
    public function findByAll(): array;

    public function update(Role $role): void;

    public function deleteAll(): bool;
}
