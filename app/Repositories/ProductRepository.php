<?php

namespace App\Repositories;

use App\Models\Product;
use App\Exceptions\InvalidArgumentTypeException;
use Carbon\Carbon;

/**
 * Class ProductRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Repositories
 */
class ProductRepository extends BaseRepository
{
    const MODEL = 'App\Models\Product';

    /**
     * Create new product.
     *
     * @param array $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes)
    {
        $attributes = array_merge($attributes, ['created_at' => Carbon::now()->toDateTimeString()]);

        return Product::create($attributes);
    }

    /**
     * Join products with items and get it.
     *
     * @param int|array $id      One identifier or array with products identifiers.
     * @param array     $columns Columns for sample.
     *
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public function getWithItems($id, $columns = [])
    {
        $columns = $this->prepareColumns($columns);
        $builder = Product::select($columns)
            ->join('items', 'items.id', '=', 'products.item_id');

        if (is_array($id)) {
            return $builder->whereIn('products.id', $id)->get();
        } else {
            return $builder->where('products.id', $id)->first();
        }
    }

    /**
     * @param $serverId
     * @param $category
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function forCatalog($serverId, $category)
    {
        $orderBy = s_get('shop.sort');

        if ($orderBy === 'name_desc') {
            $orderField = 'items.name';
            $orderDirection = 'DESC';
        } else if ($orderBy === 'priority') {
            $orderField = 'products.sort_priority';
            $orderDirection = 'ASC';
        } else if ($orderBy === 'priority_desc') {
            $orderField = 'products.sort_priority';
            $orderDirection = 'DESC';
        } else {
            $orderField = 'items.name';
            $orderDirection = 'ASC';
        }

        return Product::select('products.id as id', 'items.name', 'items.image', 'items.type', 'products.price', 'products.stack')
            ->join('items', 'items.id', '=', 'products.item_id')
            ->where('server_id', $serverId)
            ->where('category_id', $category)
            ->orderBy($orderField, $orderDirection)
            ->paginate(s_get('catalog.products_per_page', 10));
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

        $builder = Product::select($columns)
            ->join('items', 'items.id', 'products.item_id')
            ->join('servers', 'servers.id', 'products.server_id')
            ->join('categories', 'categories.id', 'products.category_id');

        if (!is_null($orderBy)) {
            $builder->orderBy($orderBy, $orderType);
        }

        if (!is_null($filter)) {
            $builder->where('items.name', 'like', $filter . '%');
        }

        return $builder
            ->paginate(50);
    }

    /**
     * @param int   $id
     * @param array $columns
     *
     * @return mixed
     */
    public function forEditProducts($id, $columns = [])
    {
        $columns = $this->prepareColumns($columns);

        return Product::select($columns)
            ->join('items', 'items.id', 'products.item_id')
            ->where('products.id', $id)
            ->first();
    }

    /**
     * Delete item with given identifier.
     *
     * @param int $itemId
     *
     * @return bool|null
     */
    public function deleteByItemId($itemId)
    {
        if (!is_int($itemId)) {
            throw new InvalidArgumentTypeException('integer', $itemId);
        }

        return Product::where('item_id', $itemId)->delete();
    }
}
