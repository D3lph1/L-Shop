<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Products;

use App\DataTransferObjects\Admin\Product;
use App\Repositories\ItemRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ServerRepository;
use App\Services\AdminProducts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveEditedProductRequest;
use Illuminate\View\View;

/**
 * Class EditController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
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
     */
    public function render(Request $request, ItemRepository $itemRepository, ProductRepository $productRepository, ServerRepository $serverRepository): View
    {
        $product = $productRepository->forEditProducts($request->route('product'), [
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
            $this->app->abort(404);
        }

        $items = $itemRepository->all([
            'id',
            'name',
            'type'
        ]);

        $categories = $serverRepository->allWithCategories([
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
     */
    public function save(SaveEditedProductRequest $request): RedirectResponse
    {
        $dto = new Product(
            $request->get('price'),
            $request->get('stack'),
            $request->get('item'),
            $request->get('server'),
            $request->get('category'),
            $request->get('sort_priority')
        );
        $dto->setId($request->route('product'));

        $result = $this->adminProducts->edit($dto);

        if ($result) {
            $this->msg->success(__('messages.admin.products.edit.success'));
        } else {
            $this->msg->danger(__('messages.admin.products.edit.fail'));
        }

        return response()->redirectToRoute('admin.products.list', ['server' => $request->get('currentServer')->id]);
    }

    /**
     * Remove product.
     */
    public function remove(Request $request): RedirectResponse
    {
        $productId = (int)$request->route('product');
        $result = $this->adminProducts->delete($productId);

        if ($result) {
            $this->msg->info(__('messages.admin.products.remove.success'));
        } else {
            $this->msg->danger(__('messages.admin.products.remove.fail'));
        }

        return response()->redirectToRoute('admin.products.list', ['server' => $request->get('currentServer')->id]);
    }
}
