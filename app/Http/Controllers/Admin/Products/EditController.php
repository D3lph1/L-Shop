<?php

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveEditedProductRequest;

/**
 * Class EditController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Products
 */
class EditController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $product = $this->qm->productForAdmin($request->route('product'), [
            'products.id',
            'products.price',
            'products.stack',
            'products.item_id',
            'products.category_id',
            'items.name'
        ]);

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

        $categoryId = null;
        $categoryName = null;
        $serverId = null;
        $serverName = null;
        foreach ($categories as $category) {
            if ($category->category_id == $product->category_id) {
                $categoryId = $category->category_id;
                $categoryName = $category->category;
                $serverId = $category->server_id;
                $serverName = $category->server;
            }
        }

        $data = [
            'currentServer' => $request->get('currentServer'),
            'product' => $product,
            'items' => $items,
            'categories' => $categories,
            'categoryId' => $categoryId,
            'categoryName' => $categoryName,
            'serverId' => $serverId,
            'serverName' => $serverName
        ];

        return view('admin.products.edit', $data);
    }

    /**
     * @param SaveEditedProductRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveEditedProductRequest $request)
    {
        $server = (int)$request->get('server');
        $category = (int)$request->get('category');

        $categories = $this->qm->serverWithCategories($server, [
            'categories.id'
        ]);
        \Debugbar::info($request->all());
        if (!$categories) {
            \Message::danger('Неудалось сохранть товар');
            return back();
        }

        if ($categories->id != $category) {
            \Message::danger('Категория не является дочерней для заданного сервера!');
            return back();
        }

        \DB::transaction(function () use ($request, $server, $category) {
            $this->qm->updateProduct((int)$request->route('product'), [
                'price' => (double)$request->get('price'),
                'stack' => (int)$request->get('stack'),
                'item_id' => (int)$request->get('item'),
                'server_id' => $server,
                'category_id' => $category
            ]);
        });

        \Message::success('Изменения успешно сохранены');

        return response()->redirectToRoute('admin.products.list', ['server' => $request->get('currentServer')->id]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $this->qm->removeProduct((int)$request->route('product'));
        \Message::info('Товар удален');

        return response()->redirectToRoute('admin.products.list', ['server' => $request->get('currentServer')->id]);
    }
}
