<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Roles;

use App\Exceptions\Role\RoleNotFoundException;
use App\Repository\Permission\PermissionRepository;
use App\Repository\Role\RoleRepository;

class UpdatePermissionsHandler
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function handle(int $roleId, array $permissions): void
    {
        $role = $this->roleRepository->find($roleId);
        if ($role === null) {
            throw RoleNotFoundException::byId($roleId);
        }

        $permissions = $this->permissionRepository->findWhereNameIn($permissions);
        $old = $role->getPermissions();
        // Attach permissions.
        foreach ($permissions as $permission) {
            if ($old->indexOf($permission) === false) {
                $permission->getRoles()->add($role);
                $role->getPermissions()->add($permission);
            }
        }

        // Detach permissions.
        foreach ($old as $item) {
            $f = false;
            foreach ($permissions as $permission) {
                if ($permission->getId() === $item->getId()) {
                    $f = true;
                }
            }

            if (!$f) {
                $item->getRoles()->removeElement($role);
                $role->getPermissions()->removeElement($item);
            }
        }

        $this->roleRepository->update($role);
    }
}
