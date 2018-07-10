<?php
declare(strict_types = 1);

namespace App\Repository\Item;

use App\Entity\Item;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ItemRepository
{
    public function create(Item $item): void;

    public function update(Item $item): void;

    public function find(int $id): ?Item;

    public function findAll(): array;

    public function findPaginated(int $page, int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrder(string $orderBy, bool $descending, int $page, int $perPage): LengthAwarePaginator;

    public function findPaginateWithSearch(string $search, int $page, int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrderAndSearch(string $orderBy, bool $descending, string $search, int $page, int $perPage): LengthAwarePaginator;

    public function remove(Item $item): void;

    public function deleteAll(): bool;
}
