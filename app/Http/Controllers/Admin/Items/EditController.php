<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Items;

use App\DataTransferObjects\Admin\Items\Edit\Edit;
use App\Exceptions\Item\DoesNotExistException;
use App\Handlers\Admin\Items\Edit\EditHandler;
use App\Handlers\Admin\Items\Edit\RenderHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Items\EditRequest;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Notification\Notifications\Error;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
                'images' => $item->getImages()
            ]);
        } catch (DoesNotExistException $e) {
            throw new NotFoundHttpException();
        }
    }

    public function edit(EditRequest $request, EditHandler $handler): JsonResponse
    {
        $dto = (new Edit())
            ->setId((int)$request->route('item'))
            ->setName($request->get('name'))
            ->setDescription($request->get('description'))
            ->setItemType($request->get('item_type'))
            ->setImageType($request->get('image_type'))
            ->setFile($request->file('file'))
            ->setImageName($request->get('image_name'))
            ->setGameId($request->get('game_id'))
            ->setExtra($request->get('extra'));

        try {
            $handler->handle($dto);

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Success(__('msg.admin.items.edit.success')));
        } catch (DoesNotExistException $e) {
            return (new JsonResponse('not_found'))
                ->addNotification(new Error(__('msg.admin.items.edit.not_found')));
        }
    }
}
