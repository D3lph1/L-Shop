<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use App\Exceptions\Page\DoesNotExistException;
use App\Handlers\Frontend\Shop\Page\VisitHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    public function render(Request $request, VisitHandler $handler)
    {
        try {
            $page = $handler->handle($request->route('url'));

            return view('frontend.shop.page', [
                'page' => $page
            ]);
        } catch (DoesNotExistException $e) {
            throw new NotFoundHttpException();
        }
    }
}
