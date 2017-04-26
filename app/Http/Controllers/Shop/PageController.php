<?php

namespace App\Http\Controllers\Shop;

use App\Services\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class PageController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Shop
 */
class PageController extends Controller
{
    /**
     * Render given static page
     *
     * @param Request $request
     * @param Page    $page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request, Page $page)
    {
        $url = $request->route('page');
        $page = $page->getByUrl($url, ['title', 'content']);

        if (!$page) {
            \App::abort(404);
        }

        $data = [
            'currentServer' => $request->get('currentServer'),
            'page' => $page
        ];

        return view('shop.page', $data);
    }
}
