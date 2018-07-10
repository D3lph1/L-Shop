<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\News;

use App\DataTransferObjects\Admin\News\Add;
use App\Handlers\Admin\News\AddHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\News\AddEditRequest;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Notification\Notifications\Success;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;

class AddController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_NEWS_CRUD_ACCESS));
    }

    public function render(): JsonResponse
    {
        return new JsonResponse(Status::SUCCESS);
    }

    public function add(AddEditRequest $request, AddHandler $handler): JsonResponse
    {
        $handler->handle(new Add($request->get('title'), $request->get('content')));

        return (new JsonResponse(Status::SUCCESS))
            ->addNotification(new Success(__('msg.admin.news.add.success')));
    }
}
