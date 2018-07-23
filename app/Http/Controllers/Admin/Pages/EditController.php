<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Pages;

use App\DataTransferObjects\Admin\Pages\Edit\Edit;
use App\Exceptions\Page\PageNotFoundException;
use App\Handlers\Admin\Pages\Edit\EditHandler;
use App\Handlers\Admin\Pages\Edit\RenderHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pages\AddEditRequest;
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
        $this->middleware(permission_middleware(Permissions::ADMIN_PAGES_CRUD_ACCESS));
    }

    public function render(Request $request, RenderHandler $handler): JsonResponse
    {
        $page = $handler->handle((int)$request->route('page'));

        return new JsonResponse(Status::SUCCESS, [
            'page' => $page
        ]);
    }

    public function edit(AddEditRequest $request, EditHandler $handler): JsonResponse
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
        } catch (PageNotFoundException $e) {
            return (new JsonResponse('page_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.admin.pages.edit.not_found')));
        }
    }
}
