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
    /**
     * {@inheritdoc}
     */
    public function attachUser(int $roleId, int $userId): bool
    {
        $this->detachUser($roleId, $userId);

        return DB::table('role_users')->insert([
            'user_id' => $userId,
            'role_id' => $roleId
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function detachUser(int $roleId, int $userId): bool
    {
        return (bool)DB::table('role_users')
            ->where('user_id', $userId)
            ->where('role_id', $roleId)
            ->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function updatePermissions(int $id, array $permissions): bool
    {
        return (bool)EloquentRole::where('id', $id)->update([
            'permissions' => count($permissions) === 0 ? null : json_encode($permissions)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function detachAllUser(int $userId): bool
    {
        return (bool)DB::table('role_users')
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function truncate(): void
    {
        EloquentRole::truncate();
    }
}
