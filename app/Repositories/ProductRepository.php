<?php

namespace App\Repositories;

use App\Models\Product;
use App\Exceptions\InvalidArgumentTypeException;
use Carbon\Carbon;

/**
 * Class ProductRepository
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Repositories
 */
class ProductRepository extends BaseRepository
{
    const MODEL = 'App\Models\Product';

    /**
     * Create new product
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
     * Delete item with given identifier
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
