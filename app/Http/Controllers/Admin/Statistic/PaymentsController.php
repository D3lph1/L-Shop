<?php

namespace App\Http\Controllers\Admin\Statistic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $payments = $this->qm->paymentsHistoryAll();
        foreach ($payments as $payment) {
            if ($payment->user_id) {
                $users[] = $payment->user_id;
            }
        }
        $users = array_unique($users);
        $users = $this->qm->users($users, ['id', 'username']);
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
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        $payment = $this->qm->payment((int)$request->route('payment'), ['products']);

        if (!$payment) {
            return json_response('payment not found');
        }
        $unserialized = unserialize($payment->products);
        $ids = array_keys($unserialized);
        $products = $this->qm->product($ids, [
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

    public function complete(Request $request)
    {
        $result = \Artisan::call('payment:complete', ['id' => $request->route('payment')]);

        if ($result === 1) {
            \Message::danger('Платеж не найден');
        }elseif ($result === 2) {
            \Message::warning('Платеж уже завершен');
        }else {
            \Message::success('Платеж успешно подтвержден');
        }

        return back();
    }
}
