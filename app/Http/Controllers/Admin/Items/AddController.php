<?php

namespace App\Http\Controllers\Admin\Items;

use App\Services\AdminItems;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedItemRequest;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Items
 */
class AddController extends Controller
{
    /**
     * @var AdminItems
     */
    private $adminItems;

    public function __construct(AdminItems $adminItems)
    {
        $this->adminItems = $adminItems;
        parent::__construct();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.items.add', $data);
    }

    /**
     * @param SaveAddedItemRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveAddedItemRequest $request)
    {
        $name = $request->get('name');
        $description = '';
        $type = $request->get('item_type');
        $image = $request->file('image');
        $item = $request->get('item');
        $extra = $request->get('extra');

        $result = $this->adminItems->create($name, $description, $type, $image, $item, $extra);

        if ($result) {
            \Message::success('Предмет создан успешно');
        }else {
            \Message::danger('Не удалось создать предмет');
        }

        return response()->redirectToRoute('admin.items.list', ['server' => $request->get('currentServer')->id]);
    }
}
