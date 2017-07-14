<?php

namespace App\Http\Controllers\Admin\Products;

use App\Repositories\ItemRepository;
use App\Services\AdminProducts;
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
     * @var AdminProducts
     */
    private $adminProducts;

    /**
     * @param AdminProducts $adminProducts
     */
    public function __construct(AdminProducts $adminProducts)
    {
        $this->adminProducts = $adminProducts;
        parent::__construct();
    }

    /**
     * Render the edit given product page.
     *
     * @param Request        $request
     * @param ItemRepository $itemRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request, ItemRepository $itemRepository)
    {
        $product = $this->qm->productForAdmin($request->route('product'), [
            'products.id',
            'products.price',
            'products.stack',
            'products.item_id',
            'products.category_id',
            'products.sort_priority',
            'items.name',
            'items.type'
        ]);

        if (!$product) {
            \App::abort(404);
        }

        $items = $itemRepository->all([
            'id',
            'name',
            'type'
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
     * Save edited product.
     *
     * @param SaveEditedProductRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveEditedProductRequest $request)
    {
        $productId = (int)$request->route('product');
        $serverId = (int)$request->get('server');
        $categoryId = (int)$request->get('category');
        $price = (double)$request->get('price');
        $stack = (int)$request->get('stack');
        $itemId = (int)$request->get('item');
        $sortPriority = (float)$request->get('sort_priority');

        $result = $this->adminProducts->edit($productId, $price, $stack, $itemId, $serverId, $categoryId, $sortPriority);

        if ($result) {
            \Message::success(trans('messages.success.changes'));
        } else {
            \Message::danger(trans('messages.error.changes'));
        }

        return response()->redirectToRoute('admin.products.list', ['server' => $request->get('currentServer')->id]);
    }

    /**
     * Remove product
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $productId = (int)$request->route('product');
        $result = $this->adminProducts->delete($productId);

        if ($result) {
            \Message::info('Товар удален');
        } else {
            \Message::danger('Не удалось удалить товар');
        }

        return response()->redirectToRoute('admin.products.list', ['server' => $request->get('currentServer')->id]);
    }
}
