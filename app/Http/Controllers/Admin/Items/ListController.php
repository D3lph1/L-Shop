<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Items;

use App\Repositories\ItemRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\ListParent;
use Illuminate\View\View;

/**
 * Class ListController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Items
 */
class ListController extends ListParent
{
    /**
     * Render page with items list.
     */
    public function render(Request $request, ItemRepository $itemRepository): View
    {
        $orderBy = $this->checkOrderBy((string)$request->get('orderBy'));
        $orderType = $this->checkOrderType((string)$request->get('orderType'));
        $filter = $request->get('filter');

        $items = $itemRepository->forAdmin([
            'id',
            'name',
            'type',
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
