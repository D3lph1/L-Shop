<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Server;
use App\Models\Category;
use App\Exceptions\InvalidArgumentTypeException;
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

    public function serversWithCategories($columns = null)
    {
        $columns = $this->prepareColumns($columns);
        $servers = Server::select($columns)->get();
        $categories = Category::select()->get();
        $servers = $servers->toArray();

        foreach ($servers as &$server) {
            foreach ($categories as $category) {
                if ($category->server_id == $server['id']) {
                    $server['categories'][] = $category->name;
                }
            }
            $server = (object)$server;
        }

        return $servers;
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
     * @throws InvalidArgumentTypeException
     *
     * @param int|string|array $id
     * @param null             $columns
     *
     * @return mixed
     */
    public function product($id, $columns = null, $joinItems = true)
    {
        $columns = $this->prepareColumns($columns);

        if ($joinItems) {
            $builder = Product::select($columns)->join('items', 'items.id', '=', 'products.item_id');
        } else {
            $builder = Product::select($columns);
        }

        if (is_int($id) or is_string($id)) {
            return $builder
                ->where('products.id', $id)
                ->first();
        }

        if (is_array($id)) {
            return $builder
                ->whereIn('products.id', $id)
                ->get();
        }

        throw new InvalidArgumentTypeException(['integer', 'string', 'array'], $id);
    }

    /**
     * Create a new payment
     *
     * @param string $service
     * @param string $products
     * @param int    $cost
     * @param int    $user_id
     * @param string $username
     * @param int    $server_id
     * @param string $ip
     * @param bool   $complete
     *
     * @return mixed
     */
    public function createPayment($service, $products, $cost, $user_id, $username, $server_id, $ip, $complete = false)
    {
        return Payment::create([
            'service' => $service,
            'products' => $products,
            'cost' => $cost,
            'user_id' => $user_id,
            'username' => $username,
            'server_id' => $server_id,
            'ip' => $ip,
            'complete' => (bool)$complete
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

    public function paymentsHistory($user)
    {
        return Payment::select()
            ->where('payments.user_id', $user)
            ->paginate(s_get('profile.payments_per_page', 10));
    }

    /**
     * @param int         $id
     * @param null|string $service
     *
     * @return bool
     */
    public function completePayment($id, $service = null)
    {
        return Payment::where('id', $id)->update([
            'service' => $service,
            'complete' => true,
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
    }

    /**
     * @param array $credentials
     *
     * @return bool
     */
    public function putInShoppingCart(array $credentials)
    {
        return \App\Models\Cart::insert($credentials);
    }

    /**
     * @param string $player
     * @param null   $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function cartHistory($player, $server = null, $columns = null)
    {
        $columns = $this->prepareColumns($columns);

        if ($server) {
            $builder = Cart::select($columns)
                ->join('items', 'items.id', 'cart.item_id')
                ->where('cart.server', $server);
        }else{
            $builder = Cart::select($columns)
                ->join('items', 'items.id', 'cart.item_id');
        }

        return $builder
            ->where('cart.player', $player)
            ->paginate(s_get('profile.cart_items_per_page', 10));
    }

    /**
     * Checking argument on a valid type
     *
     * @throws InvalidArgumentTypeException
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

        throw new InvalidArgumentTypeException(['string', 'array'], $columns);
    }
}
