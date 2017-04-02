<?php

namespace App\Http\Controllers\Shop;

use App\Services\Cart;
use App\Traits\Responsible;
use Illuminate\Http\Request;
use App\Services\QueryManager;
use App\Services\Payments\Manager;
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
    use Responsible;

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
            'goods' => $qm->products($request->currentServer->id, $category),
            'cart' => $cart
        ];

        return view('shop.catalog', $data);
    }

    /**
     * @param Request      $request
     * @param Manager      $manager
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(Request $request, Manager $manager)
    {
        $distributor = \App::make('distributor');
        $server = (int)$request->route('server');
        $username = $request->get('username');

        if (!is_auth()) {
            $validated = $this->checkUsername($username, false);
            if ($validated !== true) {
                return $validated;
            }
        }


        $productId = [$request->route('product')];
        $productCount = [unhumanize_perm_duration($request->get('count'), $request->get('measure'))];
        $manager
            ->setServer($server)
            ->setIp($request->ip());

        if (!is_auth() and $username) {
            $manager->setUsername($username);
        }

        $payment = null;
        \DB::transaction(function () use ($manager, $distributor, $productId, $productCount, &$payment) {
            $payment = $manager->createPayment($productId, $productCount, Manager::COUNT_TYPE_NUMBER);
            if ($payment->completed) {
                $distributor->give($payment);
            }
        });

        return $this->buildResponse($server, $payment);
    }
}
