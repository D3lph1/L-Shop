<?php

namespace App\Http\Controllers\Admin\Items;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\ListParent;

/**
 * Class ListController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Items
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

        $items = $this->qm->items([
            'id',
            'name',
            'image',
            'extra'
        ], $orderBy, $orderType, $filter);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'filters' => $this->filtersAvailable,
            'items' => $items
        ];

        return view('admin.items.list', $data);
    }
}
