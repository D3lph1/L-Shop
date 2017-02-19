<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Server;
use App\Models\Category;
use App\Exceptions\InvalidTypeArgumentException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class QueryManager
 * Service in charge of working with ORM
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class QueryManager
{
    /**
     * Gets a list of activated servers
     *
     * @param null|string|array $columns
     *
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
     * @param int               $id
     * @param null|string|array $columns
     *
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
     *
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
     * @param $category
     *
     * @return mixed
     */
    public function products($serverId, $category)
    {
        return Product::select('products.id as id', 'items.name', 'items.image', 'products.price', 'products.stack')
            ->join('items', 'items.id', '=', 'products.item_id')
            ->where('server_id', $serverId)
            ->where('category_id', $category)
            ->orderBy('items.name')
            ->paginate(s_get('catalog.products_per_page', 10));
    }

    /**
     * @throws InvalidTypeArgumentException
     *
     * @param int|string $id
     * @param null       $columns
     *
     * @return mixed
     */
    public function product($id, $columns = null)
    {
        $columns = $this->prepareColumns($columns);

        if (is_int($id) or is_string($id)) {
            return Product::select($columns)
                ->join('items', 'items.id', '=', 'products.item_id')
                ->where('products.id', $id)
                ->first();
        }

        if (is_array($id)) {
            return Product::select($columns)
                ->join('items', 'items.id', '=', 'products.item_id')
                ->whereIn('products.id', $id)
                ->get();
        }

        throw new InvalidTypeArgumentException(['integer', 'string', 'array'], $id);
    }

    /**
     * Create a new payment
     *
     * @param string     $service
     * @param string     $products
     * @param            $cost
     * @param int        $user_id
     * @param string     $username
     * @param int        $server_id
     * @param string     $ip
     * @param bool       $complete
     *
     * @return mixed
     */
    public function newPayment($service, $products, $cost, $user_id, $username, $server_id, $ip, $complete = false)
    {
        return Payment::insertGetId([
            'service' => $service,
            'products' => $products,
            'cost' => $cost,
            'user_id' => $user_id,
            'username' => $username,
            'server_id' => $server_id,
            'ip' => $ip,
            'complete' => (bool)$complete,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
    }

    /**
     * @param     $columns
     * @param int $id
     *
     * @return \Eloquent|Collection
     */
    public function payment($id, $columns = null)
    {
        $columns = $this->prepareColumns($columns);

        return Payment::select($columns)
            ->where('id', $id)
            ->first();
    }

    /**
     * @param int $id
     * @param     $service
     *
     * @return bool
     */
    public function completePayment($id, $service)
    {
        return Payment::where('id', $id)->update([
            'service' => $service,
            'complete' => true,
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
    }

    public function putInShoppingCart(array $credentials)
    {
        return \App\Models\Cart::insert($credentials);
    }

    /**
     * Checking argument on a valid type
     *
     * @throws InvalidTypeArgumentException
     *
     * @param null|string|array $columns
     *
     * @return mixed
     */
    private function prepareColumns($columns = null)
    {
        if (is_null($columns)) {
            return '*';
        }

        if (is_string($columns)) {
            return $columns;
        }

        if (is_array($columns)) {
            if (count($columns) === 0) {
                return '*';
            }

            return $columns;
        }

        throw new InvalidTypeArgumentException(['string', 'array'], $columns);
    }
}
