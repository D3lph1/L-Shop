<?php

namespace App\Http\Controllers\Admin\News;

use App\Repositories\NewsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ListController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\News
 */
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
