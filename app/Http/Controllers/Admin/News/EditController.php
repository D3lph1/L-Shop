<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\News;

use App\DataTransferObjects\Admin\News\EditNews;
use App\Exceptions\News\NewsNotFoundException;
use App\Handlers\Admin\News\DeleteHandler;
use App\Handlers\Admin\News\Edit\EditHandler;
use App\Handlers\Admin\News\Edit\RenderHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\News\AddEditRequest;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Notification\Notifications\Error;
use App\Services\Notification\Notifications\Info;
use App\Services\Notification\Notifications\Success;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_NEWS_CRUD_ACCESS));
    }

    public function render(Request $request, RenderHandler $handler): JsonResponse
    {
        try {
            return new JsonResponse(Status::SUCCESS, $handler->handle((int)$request->route('news')));
        } catch (NewsNotFoundException $e) {
            return (new JsonResponse('not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND);
        }
    }

    public function edit(AddEditRequest $request, EditHandler $handler): JsonResponse
    {
        $dto = new EditNews(
            (int)$request->route('news'),
            $request->get('title'),
            $request->get('content')
        );

        try {
            $handler->handle($dto);

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Success(__('msg.admin.news.edit.success')));
        } catch (NewsNotFoundException $e) {
            return (new JsonResponse('not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.admin.news.edit.not_found', ['id' => $dto->getId()])));
        }
    }

    public function delete(Request $request, DeleteHandler $handler): JsonResponse
    {
        try {
            $handler->handle((int)$request->route('news'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Info(__('msg.admin.news.list.delete.success')));
        } catch (NewsNotFoundException $e) {
            return (new JsonResponse('not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.admin.news.list.delete.not_found')));
        }
    }
}
