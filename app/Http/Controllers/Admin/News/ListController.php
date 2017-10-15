<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\Controller;
use App\TransactionScripts\Shop\News;
use Illuminate\Http\Request;
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
    public function render(Request $request, News $news): View
    {
        $news = $news->adminList();

        return view('admin.news.list', [
            'currentServer' => $request->get('currentServer'),
            'news' => $news
        ]);
    }
}
