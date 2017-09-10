<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\News;

use App\Repositories\NewsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class ListController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\News
 */
class ListController extends Controller
{
    /**
     * Render page with news list.
     */
    public function render(Request $request, NewsRepository $newsRepository): View
    {
        $news = $newsRepository->paginate(50, ['id', 'title', 'user_id', 'created_at', 'updated_at']);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'news' => $news
        ];

        return view('admin.news.list', $data);
    }
}
