<?php
declare(strict_types = 1);

namespace App\Repository\Role;

use App\Entity\Role;

interface RoleRepository
{
    public function create(Role $role): void;

    public function update(Role $role): void;

    public function deleteAll(): bool;

    public function findByName(string $name): ?Role;
}
