<?php
declare(strict_types = 1);

namespace App\Repository\Permission;

use App\Entity\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PermissionRepository
{
    public function create(Permission $permission): void;

    public function update(Permission $permission): void;

    public function remove(Permission $permission): void;

    public function deleteAll(): bool;

    public function find(int $id): ?Permission;

    public function findByName(string $name): ?Permission;

    /**
     * @param string[] $names
     *
     * @return Permission[]
     */
    public function findWhereNameIn(array $names): array;

    /**
     * @return Permission[]
     */
    public function findAll(): array;

    public function findPaginated(int $page, int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrder(string $orderBy, bool $descending, int $page, int $perPage): LengthAwarePaginator;

    public function findPaginateWithSearch(string $search,int $page, int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrderAndSearch(string $orderBy, bool $descending, string $search, int $page, int $perPage): LengthAwarePaginator;
}
