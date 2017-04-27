<?php

namespace App\Http\Controllers\Shop;

use App\Repositories\NewsRepository;
use App\Services\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class NewsController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Shop
 */
class NewsController extends Controller
{
    /**
     * @var NewsRepository
     */
    private $newsRepository;

    /**
     * @param NewsRepository $newsRepository
     */
    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
        parent::__construct();
    }


    /**
     * Render news page
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        if (!s_get('news.enabled')) {
            \Message::warning('Отображение новостей отключено');

            return back();
        }

        $id = (int)$request->route('id');
        $news = $this->newsRepository->find($id);

        if (!$news) {
            \App::abort(404);
        }

        $data = [
            'currentServer' => $request->get('currentServer'),
            'news' => $news
        ];

        return view('shop.news', $data);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function load(Request $request, News $news)
    {
        if (!s_get('news.enabled')) {
            return json_response('news disabled');
        }

        $count = (int)$request->get('count');
        $serverId = $request->get('currentServer')->id;

        return $news->load($count, $serverId);
    }
}
