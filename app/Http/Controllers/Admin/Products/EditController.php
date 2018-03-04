<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Products;

use App\DataTransferObjects\Admin\Products\Edit\Edit;
use App\Handlers\Admin\Products\Edit\EditHandler;
use App\Handlers\Admin\Products\Edit\RenderHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\EditRequest;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Notification\Notifications\Error;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\Request;
use App\Exceptions\Item\DoesNotExistException as ItemDoesNotExistException;
use App\Exceptions\Category\DoesNotExistException as CategoryDoesNotExistException;
use App\Exceptions\Product\DoesNotExistException as ProductDoesNotExistException;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_PRODUCTS_CRUD_ACCESS));
    }

    public function render(Request $request, RenderHandler $handler): JsonResponse
    {
        $dto = $handler->handle((int)$request->route('product'));

        return new JsonResponse(Status::SUCCESS, [
            'product' => $dto->getProduct(),
            'items' => $dto->getItems(),
            'servers' => $dto->getServers()
        ]);
    }

    public function edit(EditRequest $request, EditHandler $handler): JsonResponse
    {
        $dto = (new Edit())
            ->setProduct((int)$request->route('product'))
            ->setItem((int)$request->get('item'))
            ->setCategory((int)$request->get('category'))
            ->setPrice((float)$request->get('price'))
            ->setStack($request->get('forever') ? 0 : (int)$request->get('stack'))
            ->setSortPriority((float)$request->get('sort_priority'))
            ->setHidden((bool)$request->get('hidden'));

        try {
            $handler->handle($dto);

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Success(__('msg.admin.products.edit.success')));
        }  catch (ProductDoesNotExistException $e) {
            return (new JsonResponse('product_not_found'))
                ->addNotification(new Error(__('msg.admin.products.edit.product_not_found')));
        } catch (ItemDoesNotExistException $e) {
            return (new JsonResponse('item_not_found'))
                ->addNotification(new Error(__('msg.admin.products.edit.item_not_found')));
        } catch (CategoryDoesNotExistException $e) {
            return (new JsonResponse('category_not_found'))
                ->addNotification(new Error(__('msg.admin.products.edit.category_not_found')));
        }
    }
}
