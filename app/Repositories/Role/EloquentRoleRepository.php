<?php
declare(strict_types = 1);

namespace App\Repositories\Role;

use App\Models\Role\EloquentRole;
use Cartalyst\Sentinel\Roles\IlluminateRoleRepository;

class EloquentRoleRepository extends IlluminateRoleRepository implements RoleRepositoryInterface
{
    public function truncate(): void
    {
        EloquentRole::truncate();
    }
}
