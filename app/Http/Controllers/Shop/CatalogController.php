<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    public function render(Request $request)
    {
        $id = (int)$request->route('server');
        $qm = \App::make('qm');
        $server = $qm->serverOrFail($id, ['id', 'name']);
        $servers = $qm->listOfEnabledServers(['id', 'name']);

        $data = [
            'currentServer' => $server,
            'servers' => $servers,
            'username' => is_auth() ? \Sentinel::getUser()->getUserLogin() : null,
            'balance' => is_auth() ? \Sentinel::getUser()->getBalance() : null,
            'shopName' => s_get('shop.name', 'L - Shop'),

            'categories' => $qm->serverCategories($server->id),
            'goods' => $qm->goods($server->id)
        ];

        return view('shop.catalog', $data);
    }
}
