<?php
declare(strict_types = 1);

namespace App\Repositories\Item;

use App\DataTransferObjects\Item;
use App\Models\Item\ItemInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ItemRepositoryInterface
{
    public function create(Item $dto): ItemInterface;

    public function find(int $id, array $columns): ?ItemInterface;

    public function update(int $id, array $attributes): bool;

    public function delete(int $id): bool;

    public function exists(int $id): bool;

    public function all(array $columns): iterable;

    public function forAdmin(
        array $columns,
        string $orderBy,
        string $orderType = 'ASC',
        ?string $filter): LengthAwarePaginator;
}
