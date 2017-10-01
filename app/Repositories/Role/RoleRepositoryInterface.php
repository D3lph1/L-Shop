<?php
declare(strict_types = 1);

namespace App\Repositories\Role;

use App\Models\Role\RoleInterface;
use App\Models\User\UserInterface;
use App\Repositories\BaseRepositoryInterface;
use Cartalyst\Sentinel\Roles\RoleRepositoryInterface as BaseRoleRepositoryInterface;

/**
 * Interface RoleRepositoryInterface
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Role
 */
interface RoleRepositoryInterface extends BaseRoleRepositoryInterface, BaseRepositoryInterface
{
    public function attachUser(RoleInterface $role, UserInterface $user): bool;
}
