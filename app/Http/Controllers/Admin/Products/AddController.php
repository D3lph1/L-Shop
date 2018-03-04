<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin\Products;

use App\DataTransferObjects\Admin\Products\Add\Add;
use App\Exceptions\Category\DoesNotExistException as CategoryDoesNotExistException;
use App\Exceptions\Item\DoesNotExistException as ItemDoesNotExistException;
use App\Handlers\Admin\Products\Add\AddHandler;
use App\Handlers\Admin\Products\Add\RenderHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\AddRequest;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;

class AddController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_PRODUCTS_CRUD_ACCESS));
    }

    public function render(RenderHandler $handler): JsonResponse
    {
        $dto = $handler->handle();

        return new JsonResponse(Status::SUCCESS, [
            'items' => $dto->getItems(),
            'servers' => $dto->getServers()
        ]);
    }

    public function add(AddRequest $request, AddHandler $handler): JsonResponse
    {
        $dto = (new Add())
            ->setItem((int)$request->get('item'))
            ->setCategory((int)$request->get('category'))
            ->setPrice((float)$request->get('price'))
            ->setStack($request->get('forever') ? 0 : (int)$request->get('stack'))
            ->setSortPriority((float)$request->get('sort_priority'))
            ->setHidden((bool)$request->get('hidden'));

        try {
            $handler->handle($dto);

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Success(__('msg.admin.products.add.success')));
        } catch (ItemDoesNotExistException $e) {
            return (new JsonResponse('item_not_found'))
                ->addNotification(new Success(__('msg.admin.products.add.item_not_found')));
        } catch (CategoryDoesNotExistException $e) {
            return (new JsonResponse('category_not_found'))
                ->addNotification(new Success(__('msg.admin.products.add.category_not_found')));
        }
    }
}
