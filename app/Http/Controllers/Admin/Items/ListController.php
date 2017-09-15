<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Admin\ListParent;
use App\Repositories\ItemRepository;
use App\TransactionScripts\Items;
use Illuminate\Http\Request;
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
    public function render(Request $request, Items $script): View
    {
        $orderBy = $request->get('orderBy');
        $orderType = $request->get('orderType');
        $filter = $request->get('filter');

        $items = $script->informationForList($orderBy, $orderType, $filter);

        return view('admin.items.list', [
            'currentServer' => $request->get('currentServer'),
            'filters' => $this->filtersAvailable,
            'items' => $items
        ]);
    }
}
