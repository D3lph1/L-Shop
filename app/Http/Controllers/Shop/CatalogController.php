<?php

namespace App\Http\Controllers\Shop;

use App\Exceptions\Payment\InvalidProductsCountException;
use App\Exceptions\User\InvalidUsernameException;
use App\Http\Controllers\Controller;
use App\Services\QueryManager;
use Illuminate\Http\Request;
use App\Services\CatalogBuy;
use App\Traits\BuyResponse;
use App\Services\Cart;

/**
 * Class CatalogController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Shop
 */
class CatalogController extends Controller
{
    use BuyResponse;

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
            'goods' => $qm->products($request->get('currentServer')->id, $category),
            'cart' => $cart
        ];

        return view('shop.catalog', $data);
    }

    /**
     * @param Request    $request
     * @param CatalogBuy $handler
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(Request $request, CatalogBuy $handler)
    {
        $server = (int)$request->route('server');
        $ip = $request->ip();
        $username = $request->get('username');
        $count = $request->get('count');

        try {
            return $handler->buy($request->route('product'), $count, $server, $ip, $username);
        } catch (InvalidUsernameException $e) {
            return json_response('invalid username');
        } catch (InvalidProductsCountException $e) {
            return json_response('invalid products count');
        }
    }
}
