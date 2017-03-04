<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Item;
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
    public function listOfServers($columns = null)
    {
        $columns = $this->prepareColumns($columns);

        return Server::select($columns)->get();
    }

    /**
     * Get server or drop 404
     *
     * @param int               $id
     * @param null|string|array $columns
     *
     * @return mixed
     */
    public function server($id, $columns = null)
    {
        $columns = $this->prepareColumns($columns);

        return Server::select($columns)->find($id);
    }

    /**
     * @param int  $id
     * @param null $columns
     *
     * @return mixed
     */
    public function serverWithCategories($id, $columns = null)
    {
        $columns = $this->prepareColumns($columns);

        return Server::select($columns)
            ->join('categories', 'categories.server_id', 'servers.id')
            ->find($id);
    }

    /**
     * @param array $credentials
     *
     * @return int
     */
    public function createServer(array $credentials)
    {
        return Server::insertGetId($credentials);
    }

    /**
     * @param int   $id
     * @param array $credentials
     *
     * @return bool
     */
    public function updateServer($id, array $credentials)
    {
        return Server::where('id', $id)
            ->update($credentials);
    }

    /**
     * @param string $name
     * @param int    $serverId
     *
     * @return bool
     */
    public function createCategory($name, $serverId)
    {
        return Category::insert([
            'name' => $name,
            'server_id' => $serverId
        ]);
    }

    public function createCategories(array $credentials)
    {
        return Category::insert($credentials);
    }

    /**
     * @param int   $id
     * @param array $credentials
     *
     * @return bool
     */
    public function updateCategory($id, array $credentials)
    {
        return Category::where('id', $id)
            ->update($credentials);
    }

    /**
     * @param int $serverId
     *
     * @return int
     */
    public function categoryCount($serverId)
    {
        return Category::where('server_id', $serverId)
            ->count();
    }

    /**
     * @param null|array $columns
     *
     * @return Collection|static[]
     */
    public function allCategoriesWithServers($columns = null)
    {
        $columns = $this->prepareColumns($columns);

        return Category::select($columns)
            ->join('servers', 'servers.id', 'categories.server_id')
            ->get();
    }

    /**
     * @param int $id
     *
     * @return bool|null
     */
    public function removeCategory($id)
    {
        return Category::where('id', $id)
            ->delete();
    }

    /**
     * Get the categories list for the current server
     *
     * @param int|array $serverId
     *
     * @return mixed
     */
    public function serverCategories($serverId, $columns = null)
    {
        $columns = $this->prepareColumns($columns);

        if (is_array($serverId)) {
            $builder = Category::select($columns)->whereIn('server_id', $serverId);
        } else {
            $builder = Category::select($columns)->where('server_id', $serverId);
        }

        return $builder->get();
    }

    /**
     * @param null|array $columns
     *
     * @return array|Collection|static[]
     */
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
     * @param int $id
     *
     * @return bool|null
     */
    public function removeServer($id)
    {
        return Server::where('id', $id)
            ->delete();
    }

    /**
     * @param array $credentials
     *
     * @return bool
     */
    public function createItem(array $credentials)
    {
        return Item::insert($credentials);
    }

    /**
     * @param int   $id
     * @param array $credentials
     *
     * @return bool
     */
    public function updateItem($id, array $credentials)
    {
        return Item::where('id', $id)
            ->update($credentials);
    }

    /**
     * @param null|array  $columns
     * @param null|string $orderBy
     * @param string      $orderType
     * @param null|string $filter
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function items($columns = null, $orderBy = null, $orderType = 'ASC', $filter = null)
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

    /**
     * @param int        $id
     * @param null|array $columns
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function item($id, $columns = null)
    {
        $columns = $this->prepareColumns($columns);

        return Item::select($columns)
            ->where('id', $id)
            ->first();
    }

    /**
     * @param int $id
     *
     * @return bool|null
     */
    public function removeItem($id)
    {
        return Item::where('id', $id)
            ->delete();
    }

    /**
     * @param array $credentials
     *
     * @return bool
     */
    public function createProduct(array $credentials)
    {
        return Product::insert($credentials);
    }

    /**
     * @param null|array    $columns
     *
     * @param null|string   $orderBy
     * @param string|string $orderType
     * @param null|string   $filter
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function productsForAdmin($columns = null, $orderBy = null, $orderType = 'ASC', $filter = null)
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

    public function productForAdmin($id, $columns = null)
    {
        $columns = $this->prepareColumns($columns);

        return Product::select($columns)
            ->join('items', 'items.id', 'products.item_id')
            ->where('products.id', $id)
            ->first();
    }

    /**
     * Get goods joined with items for current server (paginated)
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
     * @param int   $id
     * @param array $credentials
     *
     * @return bool
     */
    public function updateProduct($id, array $credentials)
    {
        return Product::where('id', $id)
            ->update($credentials);
    }

    /**
     * @param int $id
     *
     * @return bool|null
     */
    public function removeProduct($id)
    {
        return Product::where('id', $id)
            ->delete();
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
     * @param bool   $completed
     *
     * @return mixed
     */
    public function createPayment($service, $products, $cost, $user_id, $username, $server_id, $ip, $completed = false)
    {
        return Payment::create([
            'service' => $service,
            'products' => $products,
            'cost' => $cost,
            'user_id' => $user_id,
            'username' => $username,
            'server_id' => $server_id,
            'ip' => $ip,
            'completed' => (bool)$completed
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
            'completed' => true,
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
     * @param string     $player
     * @param null|int   $server
     * @param null|array $columns
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
        } else {
            $builder = Cart::select($columns)
                ->join('items', 'items.id', 'cart.item_id');
        }

        return $builder
            ->where('cart.player', $player)
            ->orderBy('cart.created_at', 'DESC')
            ->paginate(s_get('profile.cart_items_per_page', 10));
    }

    /**
     * @param int $server
     */
    public function enableServer($server)
    {
        $this->changeServerEnabledMode($server, 1);
    }

    /**
     * @param int $server
     */
    public function disableServer($server)
    {
        $this->changeServerEnabledMode($server, 0);
    }

    /**
     * @param int $id
     * @param int $mode
     */
    private function changeServerEnabledMode($id, $mode)
    {
        Server::where('id', $id)->update(['enabled' => $mode]);
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
