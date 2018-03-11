<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Pages;

use App\DataTransferObjects\Admin\Pages\Edit\Edit;
use App\Exceptions\Page\DoesNotExistException;
use App\Handlers\Admin\Pages\Edit\EditHandler;
use App\Handlers\Admin\Pages\Edit\RenderHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pages\EditRequest;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Notification\Notifications\Error;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_PAGES_CRUD_ACCESS));
    }

    public function render(Request $request, RenderHandler $handler): JsonResponse
    {
        $page = $handler->handle((int)$request->route('page'));

        return new JsonResponse(Status::SUCCESS, [
            'page' => $page
        ]);
    }

    public function edit(EditRequest $request, EditHandler $handler): JsonResponse
    {
        $dto = (new Edit())
            ->setId((int)$request->route('page'))
            ->setTitle($request->get('title'))
            ->setContent($request->get('content'))
            ->setUrl($request->get('url'));
        try {
            $handler->handle($dto);

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Success(__('msg.admin.pages.edit.success')));
        } catch (DoesNotExistException $e) {
            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Error(__('msg.admin.pages.edit.not_found')));
        }
    }
}
