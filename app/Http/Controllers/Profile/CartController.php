<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * Render the profile cart page
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $items = $this->qm->cartHistory(\Sentinel::getUser()->getUserLogin(), null, [
            'cart.amount',
            'cart.created_at',
            'cart.server',
            'items.name',
            'items.image',
        ]);

        $data = [
            'servers' => $request->get('servers'),
            'items' => $items
        ];

        return view('profile.cart', $data);
    }
}
