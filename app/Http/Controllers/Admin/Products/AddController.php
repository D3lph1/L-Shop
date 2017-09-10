<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Products;

use App\DataTransferObjects\Admin\Product;
use App\Exceptions\ItemNotFoundException;
use App\Http\Requests\Admin\SaveAddedProductRequest;
use App\Repositories\ItemRepository;
use App\Repositories\ServerRepository;
use App\Services\AdminProducts;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Products
 */
class AddController extends Controller
{
    /**
     * @var AdminProducts
     */
    private $adminProducts;

    public function __construct(AdminProducts $adminProducts)
    {
        $this->adminProducts = $adminProducts;

        parent::__construct();
    }

    /**
     * Render the add product page.
     */
    public function render(Request $request, ItemRepository $itemRepository, ServerRepository $serverRepository): View
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
     */
    public function save(SaveAddedProductRequest $request): RedirectResponse
    {
        $result = null;
        $dto = new Product(
            $request->get('price'),
            $request->get('stack'),
            $request->get('item'),
            $request->get('server'),
            $request->get('category'),
            $request->get('sort_priority')
        );

        try {
            $result = $this->adminProducts->create($dto);
        } catch (ItemNotFoundException $e) {
            $this->msg->danger(__('messages.admin.products.add.item_not_found', ['id' => $dto->getItemId()]));
        }

        if ($result) {
            $this->msg->success(__('messages.admin.products.add.success'));
        }else {
            $this->msg->danger(__('messages.admin.products.add.fail'));
        }

        return response()->redirectToRoute('admin.products.list', ['server' => $request->get('currentServer')->id]);
    }
}
