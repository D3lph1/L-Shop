<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Control\Payments;

use App\Services\Response\JsonRespondent;

class VisitResult implements JsonRespondent
{
    /**
     * @var float
     */
    private $minFillBalanceSum;

    /**
     * @var bool
     */
    private $robokassaEnabled;

    /**
     * @var string|null
     */
    private $robokassaLogin;

    /**
     * @var string|null
     */
    private $robokassaPaymentPassword;

    /**
     * @var string|null
     */
    private $robokassaValidationPassword;

    /**
     * @var string|null
     */
    private $robokassaAlgorithm;

    /**
     * @var bool
     */
    private $robokassaTest;

    /**
     * @var bool
     */
    private $interkassaEnabled;

    /**
     * @var string|null
     */
    private $interkassaCheckoutId;

    /**
     * @var string|null
     */
    private $interkassaKey;

    /**
     * @var string|null
     */
    private $interkassaTestKey;

    /**
     * @var string|null
     */
    private $interkassaCurrency;

    /**
     * @var string|null
     */
    private $interkassaAlgorithm;

    /**
     * @var bool
     */
    private $interkassaTest;

    /**
     * @param float $minFillBalanceSum
     *
     * @return VisitResult
     */
    public function setMinFillBalanceSum(float $minFillBalanceSum): VisitResult
    {
        $this->minFillBalanceSum = $minFillBalanceSum;

        return $this;
    }

    /**
     * @param bool $robokassaEnabled
     *
     * @return VisitResult
     */
    public function setRobokassaEnabled(bool $robokassaEnabled): VisitResult
    {
        $this->robokassaEnabled = $robokassaEnabled;

        return $this;
    }

    /**
     * @param string|null $robokassaLogin
     *
     * @return VisitResult
     */
    public function setRobokassaLogin(?string $robokassaLogin): VisitResult
    {
        $this->robokassaLogin = $robokassaLogin;

        return $this;
    }

    /**
     * @param string|null $robokassaPaymentPassword
     *
     * @return VisitResult
     */
    public function setRobokassaPaymentPassword(?string $robokassaPaymentPassword): VisitResult
    {
        $this->robokassaPaymentPassword = $robokassaPaymentPassword;

        return $this;
    }

    /**
     * @param string|null $robokassaValidationPassword
     *
     * @return VisitResult
     */
    public function setRobokassaValidationPassword(?string $robokassaValidationPassword): VisitResult
    {
        $this->robokassaValidationPassword = $robokassaValidationPassword;

        return $this;
    }

    /**
     * @param string|null $robokassaAlgorithm
     *
     * @return VisitResult
     */
    public function setRobokassaAlgorithm(?string $robokassaAlgorithm): VisitResult
    {
        $this->robokassaAlgorithm = $robokassaAlgorithm;

        return $this;
    }

    /**
     * @param bool $robokassaTest
     *
     * @return VisitResult
     */
    public function setRobokassaTest(bool $robokassaTest): VisitResult
    {
        $this->robokassaTest = $robokassaTest;

        return $this;
    }


    /**
     * @param bool $interkassaEnabled
     *
     * @return VisitResult
     */
    public function setInterkassaEnabled(bool $interkassaEnabled): VisitResult
    {
        $this->interkassaEnabled = $interkassaEnabled;

        return $this;
    }

    /**
     * @param string|null $interkassaCheckoutId
     *
     * @return VisitResult
     */
    public function setInterkassaCheckoutId(?string $interkassaCheckoutId): VisitResult
    {
        $this->interkassaCheckoutId = $interkassaCheckoutId;

        return $this;
    }

    /**
     * @param string|null $interkassaKey
     *
     * @return VisitResult
     */
    public function setInterkassaKey(?string $interkassaKey): VisitResult
    {
        $this->interkassaKey = $interkassaKey;

        return $this;
    }

    /**
     * @param string|null $interkassaTestKey
     *
     * @return VisitResult
     */
    public function setInterkassaTestKey(?string $interkassaTestKey): VisitResult
    {
        $this->interkassaTestKey = $interkassaTestKey;

        return $this;
    }

    /**
     * @param string|null $interkassaCurrency
     *
     * @return VisitResult
     */
    public function setInterkassaCurrency(?string $interkassaCurrency): VisitResult
    {
        $this->interkassaCurrency = $interkassaCurrency;

        return $this;
    }

    /**
     * @param string $interkassaAlgorithm
     *
     * @return VisitResult
     */
    public function setInterkassaAlgorithm(string $interkassaAlgorithm): VisitResult
    {
        $this->interkassaAlgorithm = $interkassaAlgorithm;

        return $this;
    }

    /**
     * @param bool $interkassaTest
     *
     * @return VisitResult
     */
    public function setInterkassaTest(bool $interkassaTest): VisitResult
    {
        $this->interkassaTest = $interkassaTest;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function response(): array
    {
        return [
            'minFillBalanceSum' => $this->minFillBalanceSum,
            'robokassaEnabled' => $this->robokassaEnabled,
            'robokassaLogin' => $this->robokassaLogin,
            'robokassaPaymentPassword' => $this->robokassaPaymentPassword,
            'robokassaValidationPassword' => $this->robokassaValidationPassword,
            'robokassaAlgorithm' => $this->robokassaAlgorithm,
            'robokassaTest' => $this->robokassaTest,

            'interkassaEnabled' => $this->interkassaEnabled,
            'interkassaCheckoutId' => $this->interkassaCheckoutId,
            'interkassaKey' => $this->interkassaKey,
            'interkassaTestKey' => $this->interkassaTestKey,
            'interkassaCurrency' => $this->interkassaCurrency,
            'interkassaAlgorithm' => $this->interkassaAlgorithm,
            'interkassaTest' => $this->interkassaTest,
        ];
    }
}
