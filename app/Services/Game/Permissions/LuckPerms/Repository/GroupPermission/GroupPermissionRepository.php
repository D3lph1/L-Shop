<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Repository\GroupPermission;

interface GroupPermissionRepository
{
    public function deleteAll(): bool;
}
