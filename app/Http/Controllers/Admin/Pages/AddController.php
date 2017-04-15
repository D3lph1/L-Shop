<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Services\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedPageRequest;

class AddController extends Controller
{
    /**
     * Render add static page
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

        return view('admin.pages.add', $data);
    }

    /**
     * Save new static page
     *
     * @param SaveAddedPageRequest $request
     * @param Page                 $handler
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveAddedPageRequest $request, Page $handler)
    {
        $title = $request->get('page_title');
        $content = $request->get('page_content');
        $url = $request->get('page_url');

        if ($handler->create($title, $content, $url)) {
            \Message::success('Страница успешно создана');
        } else {
            \Message::danger('Не удалось создать страницу');
        }

        return back();
    }
}
