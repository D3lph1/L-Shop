<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Products;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\ListParent;
use Illuminate\View\View;

/**
 * Class ListController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Products
 */
class ListController extends ListParent
{
    /**
     * Render the page with products list.
     */
    public function render(Request $request, ProductRepository $productRepository): View
    {
        $orderBy = $this->checkOrderBy($request->get('orderBy'));
        $orderType = $this->checkOrderType($request->get('orderType'));
        $filter = $request->get('filter');

        $products = $productRepository->forAdmin([
            'products.id',
            'products.price',
            'products.item_id',
            'products.server_id',
            'products.stack',
            'products.category_id',
            'items.name',
            'items.image',
            'servers.name as server',
            'categories.name as category'
        ], $orderBy, $orderType, $filter);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'filters' => $this->filtersAvailable,
            'products' => $products
        ];

        return view('admin.products.list', $data);
    }
}
