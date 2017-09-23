<?php
declare(strict_types = 1);

namespace App\Traits;

use App\Models\Payment\PaymentInterface;
use Illuminate\Http\JsonResponse;

/**
 * Trait BuyResponse
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Traits
 */
trait BuyResponse
{
    private function buildResponse(int $serverId, PaymentInterface $payment): JsonResponse
    {
        if ($payment->isCompleted()) {
            return $this->buildQuickResponse();
        }

        return $this->buildNotQuickResponse($serverId, $payment->getId());
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
