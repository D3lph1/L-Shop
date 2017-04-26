<?php

namespace App\Http\Controllers\Admin\News;

use App\Exceptions\News\UnableToCreateNews;
use App\Http\Requests\Admin\SaveAddedNewsRequest;
use App\Services\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddController extends Controller
{
    /**
     * Render add news page
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.news.add', $data);
    }

    /**
     * Save added news
     *
     * @param SaveAddedNewsRequest $request
     * @param News                 $news Service - handler
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveAddedNewsRequest $request, News $news)
    {
        $title = $request->get('news_title');
        $content = $request->get('news_content');
        $userId = \Sentinel::getUser()->getUserId();

        try {
            $news->add($title, $content, $userId);
        } catch (UnableToCreateNews $e) {
            \Message::danger('Не удалось опубликовать новость');

            return back();
        }
        \Message::success('Новость успешно опубликована!');

        return response()->redirectToRoute('admin.news.list', ['server' => $request->get('currentServer')->id]);
    }
}
