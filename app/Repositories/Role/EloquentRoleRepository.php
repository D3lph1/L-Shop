<?php
declare(strict_types = 1);

namespace App\Repositories\Role;

use App\Models\Role\EloquentRole;
use Cartalyst\Sentinel\Roles\IlluminateRoleRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentRoleRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Role
 */
class EloquentRoleRepository extends IlluminateRoleRepository implements RoleRepositoryInterface
{
    public function attachUser(int $roleId, int $userId): bool
    {
        return DB::table('role_users')->insert([
            'user_id' => $roleId,
            'role_id' => $userId
        ]);
    }

    public function detachUser(int $roleId, int $userId): bool
    {
        return (bool)DB::table('role_users')
            ->where('user_id', $userId)
            ->where('role_id', $roleId)
            ->delete();
    }

    public function detachAllUser(int $userId): bool
    {
        return (bool)DB::table('role_users')
            ->where('user_id', $userId)
            ->delete();
    }

    public function truncate(): void
    {
        EloquentRole::truncate();
    }
}
