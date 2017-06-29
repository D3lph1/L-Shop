<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Services\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedPageRequest;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Pages
 */
class AddController extends Controller
{
    /**
     * Render add static page.
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
     * Save new static page.
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

        return response()->redirectToRoute('admin.pages.list', ['server' => $request->get('currentServer')->id]);
    }
}
