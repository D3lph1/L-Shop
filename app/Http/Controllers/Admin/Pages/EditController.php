<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Requests\Admin\SaveEditedPageRequest;
use App\Services\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    private $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
        parent::__construct();
    }

    public function render(Request $request)
    {
        $id = (int)$request->route('id');
        $page = $this->page->getById($id, ['title', 'content', 'url']);

        if (!$page) {
            \App::abort(404);
        }

        $data = [
            'currentServer' => $request->get('currentServer'),
            'id' => $id,
            'page' => $page
        ];

        return view('admin.pages.edit', $data);
    }

    /**
     * Handle save edited static page request
     *
     * @param SaveEditedPageRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveEditedPageRequest $request)
    {
        $id = (int)$request->route('id');
        $title = $request->get('page_title');
        $content = $request->get('page_content');
        $url = $request->get('page_url');

        if (!$this->page->isUrlUnique($id, $url)) {
            \Message::danger('Страница с таким адресом уже существует!');

            return back();
        }

        $result = $this->page->update($id, [
            'title' => $title,
            'content' => $content,
            'url' => $url
        ]);

        if ($result) {
            \Message::success('Страница успешно обновлена');
        } else {
            \Message::danger('Не удалось обновить страницу');
        }

        return back();
    }

    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($this->page->delete($id)) {
            \Message::info('Страница удалена');

            return response()->redirectToRoute('admin.pages.list', ['server' => $request->get('currentServer')->id]);
        }
        \Message::danger('Не удалось удалить страницу');

        return back();
    }
}
