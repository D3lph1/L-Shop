<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Requests\Admin\SaveEditedItemRequest;
use App\Services\AdminItems;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;

/**
 * Class EditController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Items
 */
class EditController extends Controller
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
        $item = $this->qm->item($request->route('item'), [
            'id',
            'name',
            'type',
            'item',
            'image',
            'extra'
        ]);

        if (!$item) {
            \App::abort(404);
        }

        $data = [
            'currentServer' => $request->get('currentServer'),
            'item' => $item
        ];

        return view('admin.items.edit', $data);
    }

    /**
     * @param SaveEditedItemRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveEditedItemRequest $request)
    {
        $itemId = (int)$request->route('item');
        $name = $request->get('name');
        $description = '';
        $imageMode = $request->get('image_mode');
        $image = $request->file('image');
        $type = $request->get('item_type');
        $item = $request->get('item');
        $extra = $request->get('extra');

        $result = $this->adminItems->saveEdited($itemId, $name, $description, $type, $imageMode, $image, $item, $extra);

        if ($result) {
            \Message::success('Изменения успешно сохранены');
        } else {
            \Message::danger('Не удалось сохранить изменения');
        }

        return response()->redirectToRoute('admin.items.list', ['server' => $request->get('currentServer')->id]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $itemId = (int)$request->route('item');
        $result = $this->adminItems->delete($itemId);

        if ($result) {
            \Message::info('Предмет удален вместе с товарами, привязанными к нему');
        } else {
            \Message::danger('Не удалось удалить предмет');
        }

        return response()->redirectToRoute('admin.items.list', ['server' => $request->get('currentServer')->id]);
    }
}
