<?php
declare(strict_types = 1);

namespace App\Services\Auth\Acl;

use Doctrine\Common\Collections\Collection;

interface HasPermissions
{
    public function hasPermission(string $permission): bool;

    public function hasAllPermission(iterable $permissions): bool;

    public function hasAtLeastOnePermission(iterable $permissions): bool;

    public function getPermissions(): Collection;
}
