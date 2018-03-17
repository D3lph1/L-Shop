<?php
declare(strict_types = 1);

namespace App\Repository\Permission;

use App\Entity\Permission;

interface PermissionRepository
{
    public function create(Permission $permission): void;

    public function update(Permission $permission): void;

    public function deleteAll(): bool;

    public function findByName(string $name): ?Permission;

    /**
     * @param string[] $names
     *
     * @return Permission[]
     */
    public function findWhereNameIn(array $names): array;

    /**
     * @return Permission[]
     */
    public function findAll(): array;
}
