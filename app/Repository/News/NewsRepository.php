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

    public function findAllPaginated(int $perPage, int $page): LengthAwarePaginator;
}
