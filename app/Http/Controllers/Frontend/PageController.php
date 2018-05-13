<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend;

use App\Exceptions\Page\PageNotFoundException;
use App\Handlers\Frontend\Shop\Page\VisitHandler;
use App\Http\Controllers\Controller;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PageController
 * This controller works with static pages.
 */
class PageController extends Controller
{
    /**
     * Returns data to render a static page.
     *
     * @param Request      $request
     * @param VisitHandler $handler
     *
     * @return JsonResponse
     */
    public function render(Request $request, VisitHandler $handler): JsonResponse
    {
        try {
            $page = $handler->handle($request->route('url'));

            return new JsonResponse(Status::SUCCESS, $page);
        } catch (PageNotFoundException $e) {
            throw new NotFoundHttpException();
        }
    }
}
