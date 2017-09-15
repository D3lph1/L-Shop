<?php
declare(strict_types = 1);

namespace App\Repositories\News;

use App\DataTransferObjects\News;
use App\Models\News\NewsInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface NewsRepositoryInterface
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\News
 */
interface NewsRepositoryInterface
{
    public function create(News $dto): ?NewsInterface;

    public function update(int $id, News $dto): bool;

    public function delete(int $id): bool;

    public function find(int $id, array $columns): ?NewsInterface;

    public function getFirstPortion(array $columns): iterable;

    public function exists(int $id): bool;

    public function count(): int;

    public function load(int $count, array $columns): iterable;

    public function paginateWithUsers(int $perPage, array $newsColumns, array $userColumns): LengthAwarePaginator;
}
