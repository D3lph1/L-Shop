<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Items;

use App\DataTransferObjects\Item;
use App\Exceptions\Item\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveEditedItemRequest;
use App\TransactionScripts\Items;
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
     * @var Items
     */
    private $script;

    /**
     * @param Items $script
     */
    public function __construct(Items $script)
    {
        $this->script = $script;
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
        $item = null;

        try {
            $item = $this->script->find((int)$request->route('item'));
        } catch (NotFoundException $e) {
            $this->msg->danger(__('messages.admin.items.edit.not_found'));

            return response()->redirectToRoute('admin.items.list', ['server' => $request->get('currentServer')->getId()]);
        }

        return view('admin.items.edit', [
            'currentServer' => $request->get('currentServer'),
            'item' => $item
        ]);
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
            ->setName($request->get('name'))
            ->setDescription('')
            ->setImageMode($request->get('image_mode'))
            ->setImage($request->file('image'))
            ->setType($request->get('item_type'))
            ->setItem($request->get('item'))
            ->setExtra($request->get('extra'));

        $result = $this->script->update((int)$request->route('item'), $dto);

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
        $result = $this->script->delete((int)$request->route('item'));

        if ($result) {
            $this->msg->info(__('messages.admin.items.remove.success'));
        } else {
            $this->msg->danger(__('messages.admin.items.remove.fail'));
        }

        return response()->redirectToRoute('admin.items.list', ['server' => $request->get('currentServer')->id]);
    }
}
