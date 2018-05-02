<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\News;

use App\Exceptions\News\NewsNotFoundException;
use App\Handlers\Frontend\News\LoadHandler;
use App\Handlers\Frontend\News\VisitHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Shop\News\LoadRequest;
use App\Services\DateTime\Formatting\Formatter;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsController extends Controller
{
    public function render(Request $request, VisitHandler $handler, Formatter $formatter)
    {
        try {
            $news = $handler->handle((int)$request->route('news'));

            return new JsonResponse(Status::SUCCESS, [
                'news' => $news,
                'formatter' => $formatter
            ]);
        } catch (NewsNotFoundException $e) {
            throw new NotFoundHttpException();
        }
    }

    public function load(LoadRequest $request, LoadHandler $handler)
    {
        $items = $handler->load((int) $request->get('portion'));

        return new JsonResponse(Status::SUCCESS, ['items' => $items]);
    }
}
