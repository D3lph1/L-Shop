<?php

namespace App\Http\Controllers\Admin\Products;

use App\Exceptions\ItemNotFoundException;
use App\Http\Requests\Admin\SaveAddedProductRequest;
use App\Repositories\ItemRepository;
use App\Repositories\ServerRepository;
use App\Services\AdminProducts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Products
 */
class AddController extends Controller
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
     * Render the add product page.
     *
     * @param Request        $request
     * @param ItemRepository $itemRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request, ItemRepository $itemRepository, ServerRepository $serverRepository)
    {
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

        $data = [
            'currentServer' => $request->get('currentServer'),
            'items' => $items,
            'categories' => $categories
        ];

        return view('admin.products.add', $data);
    }

    /**
     * Save new product request.
     *
     * @param SaveAddedProductRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveAddedProductRequest $request)
    {
        $price = (double)$request->get('price');
        $stack = (int)$request->get('stack');
        $itemId = (int)$request->get('item');
        $serverId = (int)$request->get('server');
        $categoryId = (int)$request->get('category');
        $sortPriority = (float)$request->get('sort_priority');
        $result = false;

        try {
            $result = $this->adminProducts->create($price, $stack, $itemId, $serverId, $categoryId, $sortPriority);
        } catch (ItemNotFoundException $e) {
            \Message::danger("Предмет с идентификатором {$itemId} не найден");
        }

        if ($result) {
            \Message::success('Товар добавлен');
        }else {
            \Message::danger('Не удалось добавить товар');
        }

        return response()->redirectToRoute('admin.products.list', ['server' => $request->get('currentServer')->id]);
    }
}
