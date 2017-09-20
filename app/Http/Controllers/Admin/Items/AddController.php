<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Items;

use App\DataTransferObjects\Item;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedItemRequest;
use App\Services\Items\ImageMode;
use App\TransactionScripts\Items;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Items
 */
class AddController extends Controller
{
    /**
     * Render the add new item page.
     */
    public function render(Request $request): View
    {
        return view('admin.items.add', [
            'currentServer' => $request->get('currentServer')
        ]);
    }

    /**
     * Handle the add new item request.
     */
    public function save(SaveAddedItemRequest $request, Items $items): RedirectResponse
    {
        $image = $request->file('image');

        $dto = (new Item())
            ->setName($request->get('name'))
            ->setDescription('')
            ->setType($request->get('item_type'))
            ->setImageMode(is_null($image) ? ImageMode::DEFAULT : ImageMode::UPLOAD)
            ->setImage($image)
            ->setItem($request->get('item'))
            ->setExtra($request->get('extra'));

        $result = $items->create($dto);

        if ($result) {
            $this->msg->success(__('messages.admin.items.add.success'));
        }else {
            $this->msg->danger(__('messages.admin.items.add.fail'));
        }

        return response()->redirectToRoute('admin.items.list', ['server' => $request->get('currentServer')->id]);
    }
}
