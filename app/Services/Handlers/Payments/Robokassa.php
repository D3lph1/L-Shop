<?php

namespace App\Services\Handlers\Payments;

use App\Exceptions\Payment\AlreadyCompletedException;
use App\Exceptions\Payment\InvalidRequestDataException;
use App\Exceptions\Payment\NotFoundException;
use App\Exceptions\Payment\UnableToCompleteException;
use App\Repositories\PaymentRepository;
use App\Services\Payments\Robokassa\Checkout;

/**
 * Class Robokassa
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Handlers\Payments
 */
class Robokassa extends AbstractPayment
{
    const SERVICE_NAME = 'robokassa';

    /**
     * @var Checkout
     */
    private $robokassa;

    /**
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->robokassa = app(Checkout::class);
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @param array    $requestData
     * @param bool     $testing
     * @param null|int $testingPaymentId
     *
     * @throws InvalidRequestDataException
     * @throws AlreadyCompletedException
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
            $id = $requestData['InvId'];
        }

        $payment = $this->payment($id);
        $this->validatePayment($payment);
        $this->give($payment);

        return $this->robokassa->getSuccessAnswer($id);
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
        if (!$this->robokassa->validate($requestData)) {
            throw new InvalidRequestDataException();
        }
    }
}
