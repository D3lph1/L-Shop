<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Repository\GroupPermission;

use App\Services\Game\Permissions\LuckPerms\Entity\GroupPermission;

interface GroupPermissionRepository
{
    /**
     * @param string $permission
     *
     * @return GroupPermission[]
     */
    public function findByPermission(string $permission): array;

    public function findAll(): array;

    public function deleteAll(): bool;
}
