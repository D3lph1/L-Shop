<?php

namespace App\Http\Controllers\Profile;

use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class CartController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Profile
 */
class CartController extends Controller
{
    /**
     * Render the profile cart page
     *
     * @param Request        $request
     * @param CartRepository $cr
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request, CartRepository $cr)
    {
        $server = $request->get('filter_server');

        $items = $cr->historyForUser(\Sentinel::getUser()->getUserLogin(), $server, [
            'cart.amount',
            'cart.created_at',
            'cart.server',
            'items.name',
            'items.image',
        ]);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'servers' => $request->get('servers'),
            'items' => $items
        ];

        return view('profile.cart', $data);
    }
}
