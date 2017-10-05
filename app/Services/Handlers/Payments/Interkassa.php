<?php
declare(strict_types = 1);

namespace App\Services\Handlers\Payments;

use App\Exceptions\Payment\AlreadyCompletedException;
use App\Exceptions\Payment\InvalidRequestDataException;
use App\Exceptions\Payment\NotFoundException;
use App\Exceptions\Payment\UnableToCompleteException;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Repositories\PaymentRepository;
use App\Services\Payments\Interkassa\Checkout;

/**
 * Class Interkassa
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Handlers\Payments
 */
class Interkassa extends AbstractPayment
{
    const SERVICE_NAME = 'interkassa';

    /**
     * @var Checkout
     */
    private $checkout;

    /**
     * @param PaymentRepositoryInterface $paymentRepository
     */
    public function __construct(PaymentRepositoryInterface $paymentRepository, Checkout $checkout)
    {
        $this->checkout = $checkout;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @throws InvalidRequestDataException
     * @throws AlreadyCompletedException
     * @throws NotFoundException
     * @throws UnableToCompleteException
     *
     * @return string
     */
    public function handle(array $requestData, bool $testing, ?int $testingPaymentId = null): string
    {
        if ($testing) {
            $id = $testingPaymentId;
        } else {
            $this->validateRequestData($requestData);
            $id = $requestData['ik_pm_no'];
        }

        $payment = $this->payment($id);

        // If payment with this ID does not exist, exit.
        if (is_null($payment)) {
            throw new NotFoundException($id);
        }

        $this->validatePayment($payment);
        $this->give($payment);

        return $this->checkout->getSuccessAnswer();
    }

    /**
     * Validate request data.
     *
     * @throws InvalidRequestDataException
     */
    private function validateRequestData(array $requestData)
    {
        if (!$this->checkout->validate($requestData)) {
            throw new InvalidRequestDataException();
        }
    }
}
