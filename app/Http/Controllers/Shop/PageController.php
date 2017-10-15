<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Shop;

use App\Exceptions\Page\NotFoundException;
use App\Http\Controllers\Controller;
use App\Services\Page;
use App\TransactionScripts\Pages;
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
    public function render(Request $request, Pages $script): View
    {
        $page = null;
        try {
            $page = $script->get($request->route('page'));
        } catch (NotFoundException $e) {
            $this->app->abort(404);
        }

        return view('shop.page', [
            'currentServer' => $request->get('currentServer'),
            'page' => $page
        ]);
    }
}
