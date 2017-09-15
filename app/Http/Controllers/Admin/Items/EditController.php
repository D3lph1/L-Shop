<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Items;

use App\DataTransferObjects\Item;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveEditedItemRequest;
use App\Repositories\ItemRepository;
use App\Services\Handlers\Items\Admin;
use Illuminate\Http\Request;

/**
 * Class EditController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Items
 */
class EditController extends Controller
{
    /**
     * @var Admin
     */
    private $adminHandler;

    /**
     * @param Admin $adminItems
     */
    public function __construct(Admin $adminItems)
    {
        $this->adminHandler = $adminItems;
        parent::__construct();
    }

    /**
     * Render the edit item page.
     *
     * @param Request        $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer'),
            'item' => $this->adminHandler->find((int)$request->route('item'))
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
        $dto = (new Item())
            ->setId((int)$request->route('item'))
            ->setName($request->get('name'))
            ->setDescription('')
            ->setImageMode($request->get('image_mode'))
            ->setImage($request->file('image'))
            ->setType($request->get('item_type'))
            ->setItem($request->get('item'))
            ->setExtra($request->get('extra'));

        $result = $this->adminHandler->update($dto);

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
        $result = $this->adminHandler->delete((int)$request->route('item'));

        if ($result) {
            $this->msg->info(__('messages.admin.items.remove.success'));
        } else {
            $this->msg->danger(__('messages.admin.items.remove.fail'));
        }

        return response()->redirectToRoute('admin.items.list', ['server' => $request->get('currentServer')->id]);
    }
}
