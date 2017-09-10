<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Pages;

use App\Services\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class ListController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Pages
 */
class ListController extends Controller
{
    /**
     * Render the static pages list page.
     */
    public function render(Request $request, Page $page): View
    {
        $pages = $page->all();

        $data = [
            'currentServer' => $request->get('currentServer'),
            'pages' => $pages
        ];

        return view('admin.pages.list', $data);
    }
}
