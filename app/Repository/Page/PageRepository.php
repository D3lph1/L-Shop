<?php
declare(strict_types = 1);

namespace App\Repository\Page;

use App\Entity\Page;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PageRepository
{
    public function create(Page $page): void;

    public function deleteAll(): bool;

    public function findByUrl(string $url): ?Page;

    public function findPaginated(int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrder(string $orderBy, bool $descending, int $perPage): LengthAwarePaginator;

    public function findPaginateWithSearch(string $search, int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrderAndSearch(string $orderBy, bool $descending, string $search, int $perPage): LengthAwarePaginator;
}
