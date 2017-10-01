<?php
declare(strict_types = 1);

namespace App\Repositories\Role;

use App\Models\Role\EloquentRole;
use App\Models\Role\RoleInterface;
use App\Models\User\UserInterface;
use Cartalyst\Sentinel\Roles\IlluminateRoleRepository;
use Illuminate\Support\Facades\DB;

class EloquentRoleRepository extends IlluminateRoleRepository implements RoleRepositoryInterface
{
    public function attachUser(RoleInterface $role, UserInterface $user): bool
    {
        return DB::table('role_users')->insert([
            'user_id' => $user->getId(),
            'role_id' => $role->getId()
        ]);
    }

    public function truncate(): void
    {
        EloquentRole::truncate();
    }
}
