<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Shop;

use App\Exceptions\News\DisabledException;
use App\Exceptions\News\NotFoundExceptions;
use App\Http\Controllers\Controller;
use App\TransactionScripts\Shop\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class NewsController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Shop
 */
class NewsController extends Controller
{
    /**
     * Render news page
     */
    public function render(Request $request, News $news): View
    {
        $concrete = null;

        try {
            $concrete = $news->find((int)$request->route('id'));
        } catch (DisabledException $exception) {
            $this->msg->warning(__('messages.shop.catalog.news.disabled'));

            return back();
        } catch (NotFoundExceptions $e) {
            $this->app->abort(404);
        }

        $data = [
            'currentServer' => $request->get('currentServer'),
            'news' => $concrete
        ];

        return view('shop.news', $data);
    }

    public function load(Request $request, News $news): JsonResponse
    {
        try {
            $serverId = $request->get('currentServer')->getId();
            $count = (int)$request->get('count');

            return $news->load($serverId, $count);
        } catch (DisabledException $e) {
            return json_response('news disabled', [
                'more' => __('content.shop.news.read_more'),
                'message' => [
                    'type' => 'warning',
                    'text' => __('messages.shop.catalog.news.disabled')
                ]
            ]);
        }
    }
}
