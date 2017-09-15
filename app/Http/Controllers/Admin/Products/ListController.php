<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Admin\ListParent;
use App\TransactionScripts\Products;
use Illuminate\Http\Request;
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
    public function render(Request $request, Products $script): View
    {
        $orderBy = $request->get('orderBy');
        $orderType = $request->get('orderType');
        $filter = $request->get('filter');

        $products = $script->informationForList($orderBy, $orderType, $filter);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'filters' => $this->filtersAvailable,
            'products' => $products
        ];

        return view('admin.products.list', $data);
    }
}
