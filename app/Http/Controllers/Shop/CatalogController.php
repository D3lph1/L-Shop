<?php

namespace App\Http\Controllers\Shop;

use App\Services\Cart;
use App\Services\QueryManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    public function render(Request $request, QueryManager $qm, Cart $cart)
    {
        $id = (int)$request->route('server');
        $server = $qm->serverOrFail($id, ['id', 'name']);
        $servers = $qm->listOfEnabledServers(['id', 'name']);
        $categories = $qm->serverCategories($server->id);
        $category = $request->route('category');
        $f = false;
        foreach ($categories as $one) {
            if (is_null($category)) {
                $category = $one->id;
                $f = true;
                break;
            }

            if ($category == $one->id) {
                $f = true;
                break;
            }
        }

        if (!$f) {
            \App::abort(404);
        }

        $data = [
            'currentServer' => $server,
            'servers' => $servers,

            'categories' => $categories,
            'currentCategory' => $category,
            'goods' => $qm->goods($server->id, $category),
            'cart' => $cart
        ];

        return view('shop.catalog', $data);
    }
}
