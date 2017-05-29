<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Item;
use App\Models\User;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\InvalidArgumentTypeException;

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
        return Product::select('products.id as id', 'items.name', 'items.image', 'items.type', 'products.price', 'products.stack')
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
