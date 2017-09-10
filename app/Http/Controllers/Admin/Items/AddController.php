<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Items;

use App\DataTransferObjects\Admin\Item;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedItemRequest;
use App\Services\Handlers\Items\Admin;
use App\Services\Items\ImageMode;
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
     * @var Admin
     */
    private $adminItems;

    /**
     * AddController constructor.
     *
     * @param Admin $adminItems
     */
    public function __construct(Admin $adminItems)
    {
        $this->adminItems = $adminItems;
        parent::__construct();
    }

    /**
     * Render the add new item page.
     */
    public function render(Request $request): View
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.items.add', $data);
    }

    /**
     * Handle the add new item request.
     */
    public function save(SaveAddedItemRequest $request): RedirectResponse
    {
        $image = $request->file('image');

        $dto = (new Item())
            ->setName($request->get('name'))
            ->setDescription('')
            ->setType($request->get('item_type'))
            ->setImageMode(is_null($image) ? ImageMode::DEFAULT : ImageMode::UPLOAD)
            ->setImage($image)
            ->setItemId((int)$request->get('item'))
            ->setExtra($request->get('extra'));

        $result = $this->adminItems->create($dto);

        if ($result) {
            $this->msg->success(__('messages.admin.items.add.success'));
        }else {
            $this->msg->danger(__('messages.admin.items.add.fail'));
        }

        return response()->redirectToRoute('admin.items.list', ['server' => $request->get('currentServer')->id]);
    }
}
