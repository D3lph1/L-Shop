<?php

namespace App\Http\Controllers\Profile;

use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class PaymentsController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Profile
 */
class PaymentsController extends Controller
{
    /**
     * Render the profile payments history page
     *
     * @param Request           $request
     * @param PaymentRepository $pr
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request, PaymentRepository $pr)
    {
        $data = [
            'servers' => $request->get('servers'),
            'payments' => $pr->historyForUser(\Sentinel::getUser()->getUserId())
        ];

        return view('profile.payments', $data);
    }

    /**
     * @param Request           $request
     * @param PaymentRepository $paymentRepository
     * @param ProductRepository $productRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request, PaymentRepository $paymentRepository, ProductRepository $productRepository)
    {
        $payment = $paymentRepository->find((int)$request->route('payment'), ['products', 'user_id']);

        if (!$payment or ($payment->user_id != \Sentinel::getUser()->getUserId())) {
            return json_response('payment not found');
        }
        $unserialized = unserialize($payment->products);
        $ids = array_keys($unserialized);
        $products = $productRepository->getWithItems($ids, [
            'products.id',
            'items.name',
            'items.image'
        ]);

        foreach ($products as &$product) {
            foreach ($unserialized as $key => $value) {
                if ($product->id == $key) {
                    $product->count = $value;
                    if ($product->image) {
                        $img = img_path("items/$product->image");
                        if (is_file($img)) {
                            $product->image = asset("img/items/{$product->image}");
                        }
                    }else {
                        $product->image = asset('img/empty.png');
                    }
                }
            }
        }

        return json_response('success', [
            'products' => $products
        ]);
    }
}
