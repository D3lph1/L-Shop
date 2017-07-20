<?php

namespace App\Repositories;

use App\Models\Item;

/**
 * Class ItemRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Repositories
 */
class ItemRepository extends BaseRepository
{
    const MODEL = 'App\Models\Item';

    /**
     * @param array $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes)
    {
        return Item::create($attributes);
    }

    /**
     * @param array       $columns
     * @param null|string $orderBy
     * @param string      $orderType
     * @param null|string $filter
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function forAdmin($columns = [], $orderBy = null, $orderType = 'ASC', $filter = null)
    {
        $columns = $this->prepareColumns($columns);
        $builder = Item::select($columns);

        if (!is_null($orderBy)) {
            $builder->orderBy($orderBy, $orderType);
        }

        if (!is_null($filter)) {
            $builder->where('name', 'like', $filter . '%');
        }

        return $builder->paginate(50);
    }
}
