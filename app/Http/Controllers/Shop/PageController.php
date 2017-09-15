<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class PageController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Shop
 */
class PageController extends Controller
{
    /**
     * Render given static page
     */
    public function render(Request $request, Page $page): View
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
