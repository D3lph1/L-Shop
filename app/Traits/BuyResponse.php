<?php
declare(strict_types = 1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 * Trait BuyResponse
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Traits
 */
trait BuyResponse
{
    private function buildResponse(int $serverId, Payment $payment): JsonResponse
    {
        if ($payment->completed) {
            return $this->buildQuickResponse();
        }

        return $this->buildNotQuickResponse($serverId, $payment->id);
    }

    private function buildQuickResponse(): JsonResponse
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

    private function buildNotQuickResponse(int $serverId, int $paymentId): JsonResponse
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
