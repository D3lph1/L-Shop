<?php
declare(strict_types = 1);

namespace App\Repositories\User;

use App\Models\Role\RoleInterface;
use App\Models\User\UserInterface;
use App\Repositories\BaseRepositoryInterface;
use Cartalyst\Sentinel\Users\UserRepositoryInterface as BaseUserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface UserRepositoryInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\User
 */
interface UserRepositoryInterface extends BaseUserRepositoryInterface, BaseRepositoryInterface
{
    public function findByUsername(string $username, array $columns): ?UserInterface;

    public function findByEmail(string $email, array $columns): ?UserInterface;

    public function updatePermissions(int $id, array $permissions): bool;

    public function withRolesActivationsBanPaginated(
        array $userColumns,
        array $rolesColumns,
        array $activationsColumns,
        array $banColumns,
        int $perPage = 50
    ): LengthAwarePaginator;

    public function search(string $query, array $searchSpecials): iterable;

    public function whereIdIn(array $identifiers, array $columns): iterable;

    public function hasRole(UserInterface $user, RoleInterface $role): bool;

    public function incrementById(int $id, string $column, float $incValue = 1): void;

    public function delete(int $id): bool;

    public function deleteByUsername(string $username): bool;
}
