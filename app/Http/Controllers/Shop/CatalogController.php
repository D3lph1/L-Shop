<?php

namespace App\Http\Controllers\Shop;

use App\Services\Cart;
use App\Services\QueryManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class CatalogController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Shop
 */
class CatalogController extends Controller
{
    private $server;

    /**
     * Render the catalog page
     *
     * @param Request      $request
     * @param QueryManager $qm
     * @param Cart         $cart
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request, QueryManager $qm, Cart $cart)
    {
        $id = (int)$request->route('server');
        $categories = $qm->serverCategories($request->get('currentServer')->id);
        $category = $request->route('category');
        $f = false;

        // To determine the presence and keep the current category
        foreach ($categories as $one) {
            if (is_null($category)) {
                $category = $one->id;
                $f = true;
                break;
            }
            if ($category == $one->id) {
                $f = true;
                break;
            }
        }

        // If a category with this ID does not exist
        if (!$f) {
            \App::abort(404);
        }

        $data = [
            'categories' => $categories,
            'currentCategory' => $category,
            'goods' => $qm->products($request->currentServer->id, $category),
            'cart' => $cart
        ];

        return view('shop.catalog', $data);
    }

    public function buy(Request $request)
    {
        $this->server = (int)$request->route('server');
        $manager = \App::make('payment.manager.catalog');
        return $manager->handle($request);
    }
}
