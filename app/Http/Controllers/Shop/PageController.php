<?php

namespace App\Http\Controllers\Shop;

use App\Services\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
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
