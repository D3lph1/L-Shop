<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Services\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function render(Request $request, Page $page)
    {
        $pages = $page->all();

        $data = [
            'currentServer' => $request->get('currentServer'),
            'pages' => $pages
        ];

        return view('admin.pages.list', $data);
    }
}
