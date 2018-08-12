<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Control\Payments;

use App\DataTransferObjects\Admin\Control\Payments\VisitResult;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

class VisitHandler
{
    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function handle(): VisitResult
    {
        return (new VisitResult())
            ->setMinFillBalanceSum($this->settings->get('purchasing.min_fill_balance_sum')->getValue(DataType::FLOAT))
            ->setCurrency($this->settings->get('shop.currency.name')->getValue())
            ->setCurrencyHtml($this->settings->get('shop.currency.html')->getValue())
            ->setRobokassaEnabled($this->settings->get('purchasing.services.robokassa.enabled')->getValue(DataType::BOOL))
            ->setRobokassaLogin($this->settings->get('purchasing.services.robokassa.login')->getValue())
            ->setRobokassaPaymentPassword($this->settings->get('purchasing.services.robokassa.payment_password')->getValue())
            ->setRobokassaValidationPassword($this->settings->get('purchasing.services.robokassa.validation_password')->getValue())
            ->setRobokassaAlgorithm($this->settings->get('purchasing.services.robokassa.algorithm')->getValue())
            ->setRobokassaTest($this->settings->get('purchasing.services.robokassa.test')->getValue(DataType::BOOL))

            ->setInterkassaEnabled($this->settings->get('purchasing.services.interkassa.enabled')->getValue(DataType::BOOL))
            ->setInterkassaCheckoutId($this->settings->get('purchasing.services.interkassa.checkout_id')->getValue())
            ->setInterkassaKey($this->settings->get('purchasing.services.interkassa.key')->getValue())
            ->setInterkassaTestKey($this->settings->get('purchasing.services.interkassa.test_key')->getValue())
            ->setInterkassaCurrency($this->settings->get('purchasing.services.interkassa.currency')->getValue())
            ->setInterkassaAlgorithm($this->settings->get('purchasing.services.interkassa.algorithm')->getValue())
            ->setInterkassaTest($this->settings->get('purchasing.services.interkassa.test')->getValue(DataType::BOOL));
    }
}
