<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\News;

use App\Exceptions\News\NewsNotFoundException;
use App\Handlers\Frontend\News\LoadHandler;
use App\Handlers\Frontend\News\VisitHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Shop\News\LoadRequest;
use App\Services\DateTime\Formatting\Formatter;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class NewsController
 * Respondents for output news data.
 */
class NewsController extends Controller
{
    /**
     * Render page with full news.
     *
     * @param Request      $request
     * @param VisitHandler $handler
     * @param Formatter    $formatter
     *
     * @return JsonResponse
     */
    public function render(Request $request, VisitHandler $handler, Formatter $formatter): JsonResponse
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

    /**
     * Load news by portions.
     *
     * @param LoadRequest $request
     * @param LoadHandler $handler
     *
     * @return JsonResponse
     */
    public function load(LoadRequest $request, LoadHandler $handler): JsonResponse
    {
        $items = $handler->load((int) $request->get('portion'));

        return new JsonResponse(Status::SUCCESS, ['items' => $items]);
    }
}
