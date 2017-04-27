<?php

namespace App\Http\Controllers\Admin\News;

use App\Exceptions\News\UnableToUpdate;
use App\Http\Requests\Admin\SaveEditedNewsRequest;
use App\Repositories\NewsRepository;
use App\Services\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    public function render(Request $request, NewsRepository $newsRepository)
    {
        $id = (int)$request->route('id');
        $news = $newsRepository->find($id);

        if (!$news) {
            \App::abort(404);
        }

        $data = [
            'currentServer' => $request->get('currentServer'),
            'news' => $news
        ];

        return view('admin.news.edit', $data);
    }

    /**
     * @param SaveEditedNewsRequest $request
     * @param News                  $news
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveEditedNewsRequest $request, News $news)
    {
        $id = (int)$request->route('id');
        $title = $request->get('news_title');
        $content = $request->get('news_content');

        try {
            $news->update($id, $title, $content);
        } catch (UnableToUpdate $e) {
            \Log::error($e);
            \Message::danger('Не удалось обновить новость');

            return back();
        }
        \Message::success('Новость успешно обновлена!');

        return response()->redirectToRoute('admin.news.list', ['server' => $request->get('currentServer')->id]);
    }

    public function remove(Request $request, News $news)
    {
        $id = (int)$request->route('id');
        if ($news->delete($id)) {
            \Message::info('Новость удалена');
        } else {
            \Message::danger('Не удалось удалить новость');
        }
        $news->forgetNews();
        $news->forgetCount();

        return response()->redirectToRoute('admin.news.list', ['server' => $request->get('currentServer')->id]);
    }
}
