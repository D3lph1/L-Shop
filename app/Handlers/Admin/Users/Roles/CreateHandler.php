<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Roles;

use App\Entity\Role;
use App\Exceptions\Permission\PermissionNotFoundException;
use App\Exceptions\Role\RoleAlreadyExistsException;
use App\Repository\Permission\PermissionRepository;
use App\Repository\Role\RoleRepository;

class CreateHandler
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

    /**
     * @param string $name
     * @param array $permissions
     *
     * @throws PermissionNotFoundException
     * @throws RoleAlreadyExistsException
     */
    public function handle(string $name, array $permissions): void
    {
        $allPermissions = $this->permissionRepository->findAll();
        $role = new Role($name);

        foreach ($permissions as $permission) {
            $permissionEntity = null;
            foreach ($allPermissions as $each) {
                if ($permission === $each->getName()) {
                    $permissionEntity = $each;
                }
            }

            if ($permissionEntity === null) {
                throw PermissionNotFoundException::byName($permission);
            } else {
                $role->getPermissions()->add($permissionEntity);
            }
        }

        if ($this->roleRepository->findByName($name) !== null) {
            throw RoleAlreadyExistsException::withName($name);
        }

        $this->roleRepository->create($role);
    }
}
