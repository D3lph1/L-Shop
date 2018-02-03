<?php
declare(strict_types = 1);

use App\Entity\Permission;
use App\Entity\Role;
use App\Repository\Permission\PermissionRepository;
use App\Repository\Role\RoleRepository;
use App\Services\Auth\Permissions;
use App\Services\Auth\Roles;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    private $roles = [
        Roles::USER => [
            //
        ],
        Roles::ADMIN => [
            Permissions::VIEWING_DISABLED_SERVERS
        ]
    ];

    public function run(RoleRepository $roleRepository, PermissionRepository $permissionRepository): void
    {
        $roleRepository->deleteAll();
        $permissionRepository->deleteAll();

        foreach ($this->roles as $key => $value) {
            $role = new Role($key);

            foreach ($value as $each) {
                $permission = $permissionRepository->findByName($each);
                if ($permission !== null) {
                    $role->addPermission($permission);
                    $permission->addRole($role);
                    $roleRepository->create($role);
                    $permissionRepository->update($permission);
                    continue;
                }
                $permission = new Permission($each);
                $permissionRepository->create($permission);
                $role->addPermission($permission);
                $permission->addRole($role);
            }
            $roleRepository->create($role);
        }
    }
}
