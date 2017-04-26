<?php

namespace App\Http\Controllers\Admin\News;

use App\Repositories\NewsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function render(Request $request, NewsRepository $newsRepository)
    {
        $news = $newsRepository->paginate(50, ['id', 'title', 'user_id', 'created_at', 'updated_at']);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'news' => $news
        ];

        return view('admin.news.list', $data);
    }
}
