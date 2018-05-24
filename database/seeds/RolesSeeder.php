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
            Permissions::ALLOW_SET_SKINS,
            Permissions::ALLOW_SET_CLOAKS,
            Permissions::PROFILE_SETTINGS_ACCESS,
            Permissions::PROFILE_PURCHASE_HISTORY_ACCESS,
            Permissions::PROFILE_GAME_CART_ACCESS
        ],
        Roles::ADMIN => [
            Permissions::SWITCH_SERVERS_STATE,
            Permissions::ALLOW_SET_HD_SKINS_IMPORTANT,
            Permissions::ALLOW_SET_HD_CLOAKS_IMPORTANT,
            Permissions::PROFILE_PURCHASE_HISTORY_ACCESS,
            Permissions::PROFILE_GAME_CART_ACCESS,
            Permissions::ADMIN_CONTROL_BASIC_ACCESS,
            Permissions::ADMIN_CONTROL_PAYMENTS_ACCESS,
            Permissions::ADMIN_CONTROL_API_ACCESS,
            Permissions::ADMIN_CONTROL_SECURITY_ACCESS,
            Permissions::ADMIN_CONTROL_OPTIMIZATION_ACCESS,
            Permissions::ADMIN_SERVERS_CRUD_ACCESS,
            Permissions::ADMIN_ITEMS_CRUD_ACCESS,
            Permissions::ADMIN_PRODUCTS_CRUD_ACCESS,
            Permissions::ADMIN_NEWS_CRUD_ACCESS,
            Permissions::ADMIN_PAGES_CRUD_ACCESS,
            Permissions::ADMIN_USERS_CRUD_ACCESS,
            Permissions::ADMIN_OTHER_RCON_ACCESS,
            Permissions::ADMIN_OTHER_DEBUG_ACCESS,
            Permissions::ADMIN_STATISTIC_SHOW_ACCESS,
            Permissions::ADMIN_STATISTIC_PURCHASES_ACCESS,
            Permissions::ALLOW_COMPLETE_PURCHASES,
            Permissions::ADMIN_INFORMATION_ABOUT_ACCESS,
            Permissions::ACCESS_WHILE_MAINTENANCE
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
