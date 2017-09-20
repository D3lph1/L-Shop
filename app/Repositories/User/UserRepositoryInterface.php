<?php
declare(strict_types = 1);

namespace App\Repositories\User;

use Cartalyst\Sentinel\Users\UserRepositoryInterface as BaseUserRepositoryInterface;

interface UserRepositoryInterface extends BaseUserRepositoryInterface
{
    public function withRolesActivationsBanPaginated(
        array $userColumns,
        array $rolesColumns,
        array $activationsColumns,
        array $banColumns,
        int $perPage = 50
    );

    public function search(string $query, array $searchSpecials): iterable;
}
