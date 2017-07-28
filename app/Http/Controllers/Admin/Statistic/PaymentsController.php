<?php

namespace App\Http\Controllers\Admin\Statistic;

use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class PaymentsController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Statistic
 */
class PaymentsController extends Controller
{
    /**
     * Render the payments list page.
     *
     * @param Request           $request
     * @param PaymentRepository $pr
     * @param UserRepository    $ur
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request, PaymentRepository $pr, UserRepository $ur)
    {
        $payments = $pr->allHistory();
        $users = [];

        foreach ($payments as $payment) {
            if ($payment->user_id) {
                $users[] = $payment->user_id;
            }
        }
        $users = array_unique($users);
        $users = $ur->whereIdIn($users, ['id', 'username']);
        foreach ($payments as &$payment) {
            foreach ($users as $user) {
                if ($user->id === $payment->user_id) {

                    $payment->username = $user->username;
                }
            }
        }

        $data = [
            'servers' => $request->get('servers'),
            'payments' => $payments,
            'currency' => s_get('shop.currency_html')
        ];

        return view('admin.statistic.payments', $data, $data);
    }

    /**
     * Get detail information about concrete payment.
     *
     * @param Request           $request
     * @param PaymentRepository $paymentRepository
     * @param ProductRepository $productRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request, PaymentRepository $paymentRepository, ProductRepository $productRepository)
    {
        $payment = $paymentRepository->find((int)$request->route('payment'), ['products']);

        if (!$payment) {
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

    /**
     * Complete given payment request.
     *
     * @param Request $request
     * @param Kernel  $artisan
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Request $request, Kernel $artisan)
    {
        $result = $artisan->call('payment:complete', ['id' => $request->route('payment')]);

        if ($result === 1) {
            $this->msg->danger(__('messages.admin.statistics.payments.complete.not_found'));
        }elseif ($result === 2) {
            $this->msg->warning(__('messages.admin.statistics.payments.complete.already_complete'));
        }else {
            $this->msg->success(__('messages.admin.statistics.payments.complete.success'));
        }

        return back();
    }
}
