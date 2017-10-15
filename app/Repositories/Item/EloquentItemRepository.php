<?php
declare(strict_types=1);

namespace App\Repositories\Item;

use App\Models\Item\EloquentItem;
use App\Models\Item\ItemInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class EloquentItemRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Item
 */
class EloquentItemRepository implements ItemRepositoryInterface
{
    public function create(ItemInterface $entity): ItemInterface
    {
        return EloquentItem::create(trim_nullable([
            'id' => $entity->getId(),
            'name' => $entity->getName(),
            'description' => $entity->getDescription(),
            'type' => $entity->getType(),
            'item' => $entity->getItem(),
            'image' => $entity->getImage(),
            'extra' => $entity->getExtra()
        ]));
    }

    public function find(int $id, array $columns): ?ItemInterface
    {
        return EloquentItem::find($id, $columns);
    }

    public function update(int $id, array $attributes): bool
    {
        return (bool)EloquentItem::where('id', $id)->update($attributes);
    }

    public function exists(int $id): bool
    {
        return EloquentItem::where('id', $id)->exists();
    }

    public function all(array $columns): iterable
    {
        return EloquentItem::all($columns);
    }

    public function forAdmin(
        array $columns,
        string $orderBy,
        string $orderType = 'ASC',
        ?string $filter): LengthAwarePaginator
    {
        {
            $builder = EloquentItem::select($columns);

            if (!is_null($orderBy)) {
                $builder->orderBy($orderBy, $orderType);
            }

            if (!is_null($filter)) {
                $builder->where('name', 'like', $filter . '%');
            }

            return $builder->paginate(50);
        }
    }

    public function delete(int $id): bool
    {
        return (bool)EloquentItem::where('id', $id)->delete();
    }

    public function truncate(): void
    {
        EloquentItem::truncate();
    }
}
