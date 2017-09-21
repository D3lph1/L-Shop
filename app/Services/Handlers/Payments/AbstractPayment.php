<?php
declare(strict_types = 1);

namespace App\Services\Handlers\Payments;

use App\Exceptions\Payment\AlreadyCompletedException;
use App\Exceptions\Payment\UnableToCompleteException;
use App\Models\Payment\PaymentInterface;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Services\Distributors\Distributor;
use App\Traits\ContainerTrait;

/**
 * Class AbstractPayment
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Handlers\Payments
 */
abstract class AbstractPayment
{
    use ContainerTrait;

    /**
     * @var PaymentRepositoryInterface
     */
    protected $paymentRepository;

    abstract public function handle(array $requestData, bool $testing, ?int $testingPaymentId = null): string;

    /**
     * @throws AlreadyCompletedException
     */
    protected function validatePayment(PaymentInterface $payment)
    {
        // If payment has already been completed.
        if ($payment->isCompleted()) {
            throw new AlreadyCompletedException($payment->getId());
        }
    }

    /**
     * @param int $id Payment identifier.
     *
     * @return mixed
     */
    protected function payment($id)
    {
        return $this->paymentRepository->find((int)$id, [
            'id',
            'products',
            'cost',
            'user_id',
            'server_id',
            'username',
            'completed'
        ]);
    }

    /**
     * Give items or money.
     *
     * @throws UnableToCompleteException
     */
    protected function give(PaymentInterface $payment): void
    {
        \DB::transaction(function () use ($payment) {
            if ($payment->getProducts()) {
                $this->giveProducts($payment);
            } else {
                $this->giveMoney($payment);
            }

            if (!$this->paymentRepository->complete($payment->getId(), static::SERVICE_NAME)) {
                throw new UnableToCompleteException();
            }
        });
    }

    /**
     * Outstanding product player.
     */
    private function giveProducts(PaymentInterface $payment): void
    {
        /** @var Distributor $distributor */
        $distributor = $this->make(Distributor::class);
        $distributor->give($payment);
    }

    /**
     * Outstanding money player.
     */
    private function giveMoney(PaymentInterface $payment): void
    {
        refill_user_balance($payment->getCost(), $payment->getUserId());
    }
}
