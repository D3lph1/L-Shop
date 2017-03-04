<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Requests\Admin\SaveAddedProductRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddController extends Controller
{
    public function render(Request $request)
    {
        $items = $this->qm->items([
            'id',
            'name'
        ]);

        $categories = $this->qm->allCategoriesWithServers([
            'categories.name as category',
            'categories.id as category_id',
            'servers.name as server',
            'servers.id as server_id'
        ]);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'items' => $items,
            'categories' => $categories
        ];

        return view('admin.products.add', $data);
    }

    public function save(SaveAddedProductRequest $request)
    {
        \DB::transaction(function () use ($request) {
            $this->qm->createProduct([
                'price' => (double)$request->get('price'),
                'stack' => (int)$request->get('stack'),
                'item_id' => (int)$request->get('item'),
                'server_id' => (int)$request->get('server'),
                'category_id' => (int)$request->get('category'),
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
        });
        \Message::success('Товар добавлен');

        return response()->redirectToRoute('admin.products.list', ['server' => $request->get('currentServer')->id]);
    }
}
