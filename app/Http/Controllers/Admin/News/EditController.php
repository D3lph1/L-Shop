<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\News;

use App\DataTransferObjects\News as DTO;
use App\Exceptions\News\DisabledException;
use App\Exceptions\News\NotFoundExceptions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveEditedNewsRequest;
use App\Traits\ContainerTrait;
use App\TransactionScripts\Shop\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class EditController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\News
 */
class EditController extends Controller
{
    use ContainerTrait;

    /**
     * Render the edit news page.
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

        return view('admin.news.edit', [
            'currentServer' => $request->get('currentServer'),
            'news' => $concrete
        ]);
    }

    /**
     * Handle the edit news request.
     */
    public function save(SaveEditedNewsRequest $request, News $news): RedirectResponse
    {
        $dto = (new DTO())
            ->setId((int)$request->route('id'))
            ->setTitle($request->get('news_title'))
            ->setContent($request->get('news_content'));

        if ($news->update($dto)) {
            $this->msg->success(__('messages.admin.news.edit.success'));

            return response()->redirectToRoute('admin.news.list', ['server' => $request->get('currentServer')->id]);
        }
        $this->msg->danger(__('messages.admin.news.edit.fail'));

        return back();
    }

    /**
     * Remove given news.
     */
    public function remove(Request $request, News $news): RedirectResponse
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
