<?php
declare(strict_types = 1);

namespace App\Repository\News;

use App\Entity\News;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface NewsRepository
{
    public function create(News $news): void;

    public function deleteAll(): bool;

    public function find(int $id): ?News;

    public function findAllPaginated(int $page, int $perPage): LengthAwarePaginator;

    public function findPaginated(int $page, int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrder(string $orderBy, bool $descending, int $page, int $perPage): LengthAwarePaginator;

    public function findPaginateWithSearch(string $search,int $page, int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrderAndSearch(string $orderBy, bool $descending, string $search, int $page, int $perPage): LengthAwarePaginator;
}
