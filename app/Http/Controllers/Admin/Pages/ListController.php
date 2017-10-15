<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Services\Page;
use App\TransactionScripts\Pages;
use Illuminate\Http\Request;
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
    public function render(Request $request, Pages $script): View
    {
        return view('admin.pages.list', [
            'currentServer' => $request->get('currentServer'),
            'pages' => $script->informationForList()
        ]);
    }
}
