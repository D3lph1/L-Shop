<?php

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\ListParent;

/**
 * Class ListController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Products
 */
class ListController extends ListParent
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $orderBy = $this->checkOrderBy($request->get('orderBy'));
        $orderType = $this->checkOrderType($request->get('orderType'));
        $filter = $request->get('filter');

        $products = $this->qm->productsForAdmin([
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
