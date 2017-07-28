<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Requests\Admin\SaveEditedItemRequest;
use App\Repositories\ItemRepository;
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

    /**
     * @param AdminItems $adminItems
     */
    public function __construct(AdminItems $adminItems)
    {
        $this->adminItems = $adminItems;
        parent::__construct();
    }

    /**
     * Render the edit item page.
     *
     * @param Request        $request
     * @param ItemRepository $itemRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request, ItemRepository $itemRepository)
    {
        $itemId = (int)$request->route('item');

        $item = $itemRepository->find($itemId, [
            'id',
            'name',
            'type',
            'item',
            'image',
            'extra'
        ]);

        if (!$item) {
            $this->app->abort(404);
        }

        $data = [
            'currentServer' => $request->get('currentServer'),
            'item' => $item
        ];

        return view('admin.items.edit', $data);
    }

    /**
     * Handle the save edited item request.
     *
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
            $this->msg->success(__('messages.admin.items.edit.success'));
        } else {
            $this->msg->danger(__('messages.admin.items.edit.fail'));
        }

        return response()->redirectToRoute('admin.items.list', ['server' => $request->get('currentServer')->id]);
    }

    /**
     * Remove item request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $itemId = (int)$request->route('item');
        $result = $this->adminItems->delete($itemId);

        if ($result) {
            $this->msg->info(__('messages.admin.items.remove.success'));
        } else {
            $this->msg->danger(__('messages.admin.items.remove.fail'));
        }

        return response()->redirectToRoute('admin.items.list', ['server' => $request->get('currentServer')->id]);
    }
}
