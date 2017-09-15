<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class PaymentsController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Profile
 */
class PaymentsController extends Controller
{
    /**
     * Render the profile payments history page.
     */
    public function render(Request $request, PaymentRepository $pr): View
    {
        $data = [
            'servers' => $request->get('servers'),
            'payments' => $pr->historyForUser(\Sentinel::getUser()->getUserId())
        ];

        return view('profile.payments', $data);
    }

    /**
     * Get more information about given payment.
     */
    public function info(Request $request, PaymentRepository $paymentRepository, ProductRepository $productRepository): JsonResponse
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
