<?php

namespace App\Traits;

use App\Models\Payment;

/**
 * Trait BuyResponse
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Traits
 */
trait BuyResponse
{
    /**
     * @param int $serverId
     * @param Payment $payment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function buildResponse($serverId, $payment)
    {
        if ($payment->completed) {
            return $this->buildQuickResponse();
        }

        return $this->buildNotQuickResponse($serverId, $payment->id);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    private function buildQuickResponse()
    {
        return json_response('success', [
            'quick' => true,
            'new_balance' => \Sentinel::getUser()->getBalance(),
            'message' => [
                'type' => 'success',
                'text' => __('messages.shop.catalog.buy.success')
            ]
        ]);
    }

    /**
     * @param int $serverId
     * @param int $paymentId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function buildNotQuickResponse($serverId, $paymentId)
    {
        return json_response('success', [
            'quick' => false,
            'redirect' => route('payment.methods', [
                'server' => $serverId,
                'payment' => $paymentId
            ])
        ]);
    }
}
