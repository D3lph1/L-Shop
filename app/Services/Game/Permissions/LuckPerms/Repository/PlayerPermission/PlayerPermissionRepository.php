<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Repository\PlayerPermission;

use App\Services\Game\Permissions\LuckPerms\Entity\PlayerPermission;

interface PlayerPermissionRepository
{
    public function create(PlayerPermission $permission): void;

    public function deleteAll(): bool;
}
