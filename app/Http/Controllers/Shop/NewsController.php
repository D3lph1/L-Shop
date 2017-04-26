<?php

namespace App\Http\Controllers\Shop;

use App\Repositories\NewsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class NewsController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
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
     * @param Request        $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function load(Request $request)
    {
        $count = (int)$request->get('count');
        $news = $this->newsRepository->load($count);

        foreach ($news as &$one) {
            $one->content = short_string($one->content, 150);
            $one->link = route('news', [
                'server' => $request->get('currentServer')->id,
                'id' => $one->id
            ]);
        }
        unset($one);
        $count = count($news);

        if ($count) {
            if ($count < s_get('news.per_page', 15)) {
                $status = 'last portion';
            } else {
                $status = 'success';
            }

            return json_response($status, [
                'news' => $news
            ]);
        }

        return json_response('no more news');
    }
}
