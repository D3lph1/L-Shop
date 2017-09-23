<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Shop;

use App\Exceptions\Payment\InvalidProductsCountException;
use App\Exceptions\User\InvalidUsernameException;
use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Cart;
use App\Services\CatalogBuy;
use App\Traits\BuyResponse;
use App\TransactionScripts\Shop\Catalog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class CatalogController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Shop
 */
class CatalogController extends Controller
{
    use BuyResponse;

    /**
     * Render the catalog page
     */
    public function render(Request $request, Catalog $catalog, Cart $cart, ProductRepositoryInterface $r): View
    {
        $server = $request->get('currentServer')->getId();
        $categories = $catalog->categories($server);
        $category = $catalog->currentCategory((int)$request->route('category'), $categories);

        $data = [
            'categories' => $categories,
            'currentCategory' => $category,
            'products' => $catalog->products($server, $category->getId()),
            'cart' => $cart
        ];

        return view('shop.catalog', $data);
    }

    public function buy(Request $request, Catalog $catalog): JsonResponse
    {
        $productId = (int)$request->route('product');
        $server = (int)$request->route('server');
        $ip = $request->ip();
        $username = $request->get('username');
        $count = (float)$request->get('count');

        try {
            return $catalog->purchase($productId, $count, $server, $ip, $username);
        } catch (InvalidUsernameException $e) {
            return json_response('invalid_username', [
                'message' => [
                    'type' => 'danger',
                    'text' => __('messages.shop.catalog.buy.invalid_username')
                ]
            ]);
        } catch (InvalidProductsCountException $e) {
            return json_response('invalid_products_count', [
                'message' => [
                    'type' => 'danger',
                    'text' => __('messages.shop.catalog.buy.invalid_count')
                ]
            ]);
        }
    }
}
