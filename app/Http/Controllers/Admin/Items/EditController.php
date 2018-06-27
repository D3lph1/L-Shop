<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Items;

use App\DataTransferObjects\Admin\Items\Add\EnchantmentFromFrontend;
use App\DataTransferObjects\Admin\Items\Edit\Edit;
use App\Exceptions\Item\ItemNotFoundException;
use App\Handlers\Admin\Items\Edit\EditHandler;
use App\Handlers\Admin\Items\Edit\RenderHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Items\EditRequest;
use App\Services\Auth\Permissions;
use App\Services\Notification\Notifications\Error;
use App\Services\Notification\Notifications\Success;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function App\permission_middleware;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_ITEMS_CRUD_ACCESS));
    }

    public function render(Request $request, RenderHandler $handler): JsonResponse
    {
        try {
            $item = $handler->handle((int)$request->route('item'));

            return new JsonResponse(Status::SUCCESS, [
                'item' => $item->getItem(),
                'images' => $item->getImages(),
                'enchantments' => $item->getEnchantments()
            ]);
        } catch (ItemNotFoundException $e) {
            return (new JsonResponse('item_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND);
        }
    }

    public function edit(EditRequest $request, EditHandler $handler): JsonResponse
    {
        $enchantments = [];
        foreach (json_decode($request->get('enchantments'), true) as $item) {
            $enchantments[] = new EnchantmentFromFrontend($item['id'], $item['level']);
        }

        $dto = (new Edit())
            ->setId((int)$request->route('item'))
            ->setName($request->get('name'))
            ->setDescription($request->get('description'))
            ->setItemType($request->get('item_type'))
            ->setImageType($request->get('image_type'))
            ->setFile($request->file('file'))
            ->setImageName($request->get('image_name'))
            ->setGameId($request->get('game_id'))
            ->setEnchantments($enchantments)
            ->setExtra($request->get('extra'));

        try {
            $handler->handle($dto);

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Success(__('msg.admin.items.edit.success')));
        } catch (ItemNotFoundException $e) {
            return (new JsonResponse('not_found'))
                ->addNotification(new Error(__('msg.admin.items.edit.not_found')));
        }
    }
}
