<?php
declare(strict_types = 1);

namespace App\Services\Auth\Acl;

use Doctrine\Common\Collections\Collection;

interface HasRoles
{
    public function hasRole(string $role): bool;

    public function hasAllRoles(iterable $roles): bool;

    public function hasAtLeastOneRole(iterable $roles): bool;

    public function getRoles(): Collection;
}
