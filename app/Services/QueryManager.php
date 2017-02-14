<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Server;
use App\Models\Category;
use App\Exceptions\InvalidTypeArgumentException;

/**
 * Service in charge of working with ORM
 */
class QueryManager
{
    /**
     * Gets a list of activated servers
     *
     * @param null|string|array $columns
     * @return mixed
     */
    public function listOfEnabledServers($columns = null)
    {
        $columns = $this->prepareColumns($columns);
        return Server::select($columns)->where('enabled', 1)->get();
    }

    /**
     * Get server or drop 404
     *
     * @param int $id
     * @param null|string|array $columns
     * @return mixed
     */
    public function serverOrFail($id, $columns = null)
    {
        $columns = $this->prepareColumns($columns);
        return Server::select($columns)->where('enabled', 1)->findOrFail($id);
    }

    /**
     * Get the categories list for the current server
     *
     * @param $serverId
     * @return mixed
     */
    public function serverCategories($serverId)
    {
        return Category::select('id', 'name')->where('server_id', $serverId)->get();
    }

    /**
     * Get goods joined with items for current server
     *
     * @param $serverId
     * @return mixed
     */
    public function goods($serverId, $category)
    {
        return Product::select('goods.id as id', 'items.name', 'items.image', 'goods.price', 'goods.stack')
            ->join('items', 'items.id', '=', 'goods.item_id')
            ->where('server_id', $serverId)
            ->where('category_id', $category)
            ->orderBy('items.name')
            ->paginate(s_get('catalog.products_per_page', 10));
    }

    /**
     * Get product by id
     *
     * @param int|string $id
     * @return mixed
     */
    public function product($id)
    {
        return Product::select('goods.id as id', 'items.name', 'items.image', 'goods.price', 'goods.stack')
            ->join('items', 'items.id', '=', 'goods.item_id')
            ->where('goods.id', $id)
            ->get();
    }

    /**
     * Checking argument on a valid type
     *
     * @param null|string|array $columns
     * @return mixed
     * @throws InvalidTypeArgumentException
     */
    private function prepareColumns($columns = null)
    {
        if (is_null($columns)) {
            return '*';
        }

        if (is_string($columns) or is_array($columns)) {
            return $columns;
        }

        throw new InvalidTypeArgumentException(['string', 'array'], $columns);
    }
}
