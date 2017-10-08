<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class CartController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Profile
 */
class CartController extends Controller
{
    /**
     * Render the profile cart page
     */
    public function render(Request $request, CartRepositoryInterface $cr): View
    {
        $server = (int)$request->get('filter_server');

        $items = $cr->historyForUser(\Sentinel::getUser()->getUserLogin(),
            $server,
            ['amount', 'cart.created_at', 'server'],
            ['name', 'type', 'image']
        );

        $data = [
            'currentServer' => $request->get('currentServer'),
            'servers' => $request->get('servers'),
            'items' => $items
        ];

        return view('profile.cart', $data);
    }
}
