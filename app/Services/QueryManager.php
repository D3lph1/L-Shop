<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Goods;
use App\Models\Item;
use App\Models\Server;
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

    public function goods($serverId)
    {
        return Goods::where('server_id', $serverId)->join('items', 'goods.item_id', '=', 'items.id')->get();
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
