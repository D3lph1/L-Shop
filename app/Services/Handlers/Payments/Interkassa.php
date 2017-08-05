<?php

namespace App\Services\Handlers\Payments;

use App\Exceptions\Payment\AlreadyCompleteException;
use App\Exceptions\Payment\InvalidRequestDataException;
use App\Exceptions\Payment\NotFoundException;
use App\Exceptions\Payment\UnableToCompleteException;
use App\Repositories\PaymentRepository;
use App\Services\Payments\Interkassa\Checkout;

class Interkassa extends AbstractPayment
{
    const SERVICE_NAME = 'interkassa';

    /**
     * @var Checkout
     */
    private $checkout;

    /**
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->checkout = app(Checkout::class);
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @param array    $requestData
     * @param bool     $testing
     * @param null|int $testingPaymentId
     *
     * @throws InvalidRequestDataException
     * @throws AlreadyCompleteException
     * @throws NotFoundException
     * @throws UnableToCompleteException
     *
     * @return string
     */
    public function handle(array $requestData, $testing, $testingPaymentId = null)
    {
        if ($testing) {
            $id = $testingPaymentId;
        } else {
            $this->validateRequestData($requestData);
            $id = $requestData['ik_pm_no'];
        }

        $payment = $this->payment($id);
        $this->validatePayment($payment);
        $this->give($payment);

        return $this->checkout->getSuccessAnswer();
    }

    /**
     * Validate request data.
     *
     * @throws InvalidRequestDataException
     *
     * @param array $requestData
     */
    private function validateRequestData(array $requestData)
    {
        if (!$this->checkout->validate($requestData)) {
            throw new InvalidRequestDataException();
        }
    }
}
