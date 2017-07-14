<?php

namespace App\Repositories;

use App\Models\Cart;

/**
 * Class CartRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Repositories
 */
class CartRepository extends BaseRepository
{
    const MODEL = 'App\Models\Cart';

    /**
     * Get gaming cart history for player with given login
     *
     * @param string   $userLogin
     * @param null|int $server
     * @param array    $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function historyForUser($userLogin, $server = null, $columns = [])
    {
        $columns = $this->prepareColumns($columns);

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
            ->where('cart.player', $userLogin)
            ->orderBy('cart.created_at', 'DESC')
            ->paginate(s_get('profile.cart_items_per_page', 10));
    }

    /**
     * Get all cart items for given player.
     *
     * @param string $player
     * @param array  $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getByPlayerWithItems($player, $columns = [])
    {
        return Cart::select($this->prepareColumns($columns))
            ->join('items', 'items.id', 'cart.item_id')
            ->where('player', $player)
            ->get();
    }
}
