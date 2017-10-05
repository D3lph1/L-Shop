<?php
declare(strict_types = 1);

namespace App\Services\User\Permissions;

use App\Models\Role\RoleInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Traits\ContainerTrait;

class RolePermissions extends Permissions
{
    use ContainerTrait;

    /**
     * @var RoleInterface
     */
    private $role;

    public function __construct(RoleInterface $role)
    {
        $this->role = $role;
        $this->specifiedPermissions = $role->getPermissions();
    }

    public function addPermission(string $name, $value): void
    {
        $this->specifiedPermissions[$name] = $value;

        /** @var RoleRepositoryInterface $repository */
        $repository = $this->make(RoleRepositoryInterface::class);
        $repository->updatePermissions($this->role->getId(), $this->specifiedPermissions);
    }

    public function deletePermission(string $name): void
    {
        unset($this->specifiedPermissions[$name]);

        /** @var RoleRepositoryInterface $repository */
        $repository = $this->make(RoleRepositoryInterface::class);
        $repository->updatePermissions($this->role->getId(), $this->specifiedPermissions);
    }
}
