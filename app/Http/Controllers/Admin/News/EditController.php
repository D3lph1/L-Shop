<?php

namespace App\Http\Controllers\Admin\News;

use App\Repositories\NewsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    public function render(Request $request, NewsRepository $newsRepository)
    {
        $id = (int)$request->route('id');
        $news = $newsRepository->find($id);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'news' => $news
        ];

        return view('admin.news.edit', $data);
    }

    public function save()
    {
        //
    }
}
