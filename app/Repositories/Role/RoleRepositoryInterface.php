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
    /**
     * Attaches the given role to the user.
     */
    public function attachUser(int $roleId, int $userId): bool;

    /**
     * Detaches the given role to the user.
     */
    public function detachUser(int $roleId, int $userId): bool;

    /**
     * Modifies the list of role privileges.
     */
    public function updatePermissions(int $id, array $permissions): bool;

    /**
     * Detaches from the user all the privileges that he has.
     */
    public function detachAllUser(int $userId): bool;
}
