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
        $qm->serverOrFail($id, ['id']);

        return view('shop.catalog');
    }
}
