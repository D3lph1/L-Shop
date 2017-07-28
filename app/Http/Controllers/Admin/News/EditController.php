<?php

namespace App\Http\Controllers\Admin\News;

use App\DataTransferObjects\Admin\News as DTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveEditedNewsRequest;
use App\Repositories\NewsRepository;
use App\Services\News;
use Illuminate\Http\Request;

/**
 * Class EditController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\News
 */
class EditController extends Controller
{
    /**
     * Render the edit news page.
     *
     * @param Request        $request
     * @param NewsRepository $newsRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request, NewsRepository $newsRepository)
    {
        $id = (int)$request->route('id');
        $news = $newsRepository->find($id);

        if (!$news) {
            $this->app->abort(404);
        }

        $data = [
            'currentServer' => $request->get('currentServer'),
            'news' => $news
        ];

        return view('admin.news.edit', $data);
    }

    /**
     * Handle the edit news request.
     *
     * @param SaveEditedNewsRequest $request
     * @param News                  $news
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveEditedNewsRequest $request, News $news)
    {
        $dto = new DTO(
            $request->get('news_title'),
            $request->get('news_content')
        );
        $dto->setId($request->route('id'));

        if ($news->update($dto)) {
            $this->msg->success(__('messages.admin.news.edit.success'));

            return response()->redirectToRoute('admin.news.list', ['server' => $request->get('currentServer')->id]);
        }
        $this->msg->danger(__('messages.admin.news.edit.fail'));

        return back();
    }

    /**
     * Remove given news.
     *
     * @param Request $request
     * @param News    $news
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request, News $news)
    {
        $id = (int)$request->route('id');
        if ($news->delete($id)) {
            $this->msg->info(__('messages.admin.news.remove.success'));
        } else {
            $this->msg->danger(__('messages.admin.news.remove.fail'));
        }

        return response()->redirectToRoute('admin.news.list', ['server' => $request->get('currentServer')->id]);
    }
}
