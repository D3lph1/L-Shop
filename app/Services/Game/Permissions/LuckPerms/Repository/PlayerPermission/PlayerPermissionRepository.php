<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Repository\PlayerPermission;

interface PlayerPermissionRepository
{
    public function deleteAll(): bool;
}
