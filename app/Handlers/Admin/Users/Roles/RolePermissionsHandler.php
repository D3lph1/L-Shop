<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Roles;

use App\Exceptions\Role\RoleNotFoundException;
use App\Repository\Role\RoleRepository;

class RolePermissionsHandler
{
    /**
     * @var RoleRepository
     */
    private $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $roleId
     * @return array
     * @throws RoleNotFoundException
     */
    public function handle(int $roleId): array
    {
        $role = $this->repository->find($roleId);
        if ($role === null) {
            throw RoleNotFoundException::byId($roleId);
        }

        $permissions = [];
        foreach ($role->getPermissions() as $permission) {
            $permissions[] = $permission->getName();
        }

        return $permissions;
    }
}
