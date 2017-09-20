<?php
declare(strict_types = 1);

namespace App\Repositories\User;

use App\Repositories\BaseRepositoryInterface;
use Cartalyst\Sentinel\Users\UserRepositoryInterface as BaseUserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface extends BaseUserRepositoryInterface, BaseRepositoryInterface
{
    public function withRolesActivationsBanPaginated(
        array $userColumns,
        array $rolesColumns,
        array $activationsColumns,
        array $banColumns,
        int $perPage = 50
    ): LengthAwarePaginator;

    public function search(string $query, array $searchSpecials): iterable;

    public function whereIdIn(array $identifiers, array $columns): iterable;
}
