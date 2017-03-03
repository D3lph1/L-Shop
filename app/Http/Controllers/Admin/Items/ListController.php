<?php

namespace App\Http\Controllers\Admin\Items;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    /**
     * @var array
     */
    private $orderByAvailable = [
        'id',
        'name'
    ];

    /**
     * @var array
     */
    private $filtersAvailable = [
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р',
        'С', 'Т', 'У', 'Ф','Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ю', 'Я', 'A', 'B', 'C', 'D', 'E', 'F', 'G',
        'H', 'I', 'J', 'K', 'L', 'K', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W',
        'X', 'Y', 'Z'
    ];

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

    /**
     * @param string $orderBy
     *
     * @return null|string
     */
    private function checkOrderBy($orderBy)
    {
        $orderBy = strtolower($orderBy);

        if (in_array($orderBy, $this->orderByAvailable)) {
            return $orderBy;
        }

        return null;
    }

    /**
     * @param string $orderType
     *
     * @return null|string
     */
    private function checkOrderType($orderType)
    {
        $orderType = strtolower($orderType);

        if ($orderType == 'asc' or $orderType == 'desc') {
            return $orderType;
        }

        return null;
    }
}
