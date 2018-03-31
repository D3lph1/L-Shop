<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Payment;

use App\DataTransferObjects\Frontend\Shop\Payment;
use App\Exceptions\ForbiddenException;
use App\Exceptions\Purchase\DoesNotExistsException;
use App\Repository\Purchase\PurchaseRepository;
use App\Services\Auth\Auth;
use App\Services\Purchasing\Payments\Interkassa\Checkout as InterkassaCheckout;
use App\Services\Purchasing\Payments\Robokassa\Checkout as RobokassaCheckout;
use App\Services\Purchasing\Payments\Robokassa\Payment as RobokassaPayment;
use App\Services\Purchasing\Payments\Interkassa\Payment as InterkassaPayment;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

class VisitHandler
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var PurchaseRepository
     */
    private $purchaseRepository;

    /**
     * @var RobokassaCheckout
     */
    private $robokassaCheckout;

    /**
     * @var InterkassaCheckout
     */
    private $interkassaCheckout;

    /**
     * @var Settings
     */
    private $settings;

    public function __construct(
        Auth $auth,
        PurchaseRepository $purchaseRepository,
        RobokassaCheckout $robokassaCheckout,
        InterkassaCheckout $interkassaCheckout,
        Settings $settings)
    {
        $this->auth = $auth;
        $this->purchaseRepository = $purchaseRepository;
        $this->robokassaCheckout = $robokassaCheckout;
        $this->interkassaCheckout = $interkassaCheckout;
        $this->settings = $settings;
    }

    public function handle(int $purchaseId): Payment
    {
        $purchase = $this->purchaseRepository->find($purchaseId);
        if ($purchase === null) {
            throw new DoesNotExistsException($purchase);
        }

        if (!$purchase->isAnonymously()) {
            if (!$this->auth->check() || ($this->auth->check() && $this->auth->getUser() !== $purchase->getUser())) {
                throw new ForbiddenException();
            }
        }

        $dto = new Payment();

        if ($this->settings->get('purchasing.services.robokassa.enabled')->getValue(DataType::BOOL)) {
            $payment = new RobokassaPayment($purchase->getId(), $purchase->getCost());
            $payment->setDescription('Purchased by L-Shop');

            $dto->setRobokassaUrl(
                $this->robokassaCheckout->paymentUrl($payment)
            );
        }
        if ($this->settings->get('purchasing.services.interkassa.enabled')->getValue(DataType::BOOL)) {
            $payment = new InterkassaPayment($purchase->getId(), $purchase->getCost());
            $payment->setDescription('Purchased by L-Shop');

            $dto->setInterkassaUrl(
                $this->interkassaCheckout->paymentUrl($payment)
            );
        }

        return $dto;
    }
}
