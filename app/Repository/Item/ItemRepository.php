<?php
declare(strict_types = 1);

namespace App\Repository\Item;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ItemRepository
{
    public function findPaginated(int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrder(string $orderBy, bool $descending, int $perPage): LengthAwarePaginator;

    public function findPaginateWithSearch(string $search, int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrderAndSearch(string $orderBy, bool $descending, string $search, int $perPage): LengthAwarePaginator;

    public function deleteAll(): bool;
}
