<?php
declare(strict_types=1);

namespace App\Repositories\Role;

use App\Repositories\BaseRepositoryInterface;
use Cartalyst\Sentinel\Roles\RoleRepositoryInterface as BaseRoleRepositoryInterface;

/**
 * Interface RoleRepositoryInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Role
 */
interface RoleRepositoryInterface extends BaseRoleRepositoryInterface, BaseRepositoryInterface
{
    public function attachUser(int $roleId, int $userId): bool;

    public function detachUser(int $roleId, int $userId): bool;

    public function updatePermissions(int $id, array $permissions): bool;

    public function detachAllUser(int $userId): bool;
}
