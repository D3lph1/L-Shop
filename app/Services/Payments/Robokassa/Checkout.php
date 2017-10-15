<?php
declare(strict_types = 1);

/**
 * This file is part of Robokassa package.
 *
 * (c) 2014 IDM Agency (http://idma.ru)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Services\Payments\Robokassa;

use App\Exceptions\Payment\Robokassa\EmptyDescriptionException;
use App\Exceptions\Payment\Robokassa\InvalidInvoiceIdException;
use App\Exceptions\Payment\Robokassa\InvalidSumException;

/**
 * Class Payment
 *
 * @author   JhaoDa <jhaoda@gmail.com>
 * @modified by D3lph1 <d3lph1.contact@gmail.com> special for L-shop project (https://github.com/D3lph1/L-shop)
 * @package  App\Services\Payments\Robokassa
 */
class Checkout
{
    const CULTURE_EN = 'en';

    const CULTURE_RU = 'ru';

    /**
     * @var string
     */
    private $culture;

    /**
     * @var string
     */
    private $baseUrl = 'http://auth.robokassa.ru/Merchant/Index.aspx?';

    /**
     * @var bool
     */
    private $isTestMode = false;

    /**
     * @var string
     */
    private $algo = 'sha512';

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $paymentPassword;

    /**
     * @var string
     */
    private $validationPassword;

    /**
     * Checkout constructor.
     */
    public function __construct(
        string $login,
        string $paymentPassword,
        string $validationPassword,
        string $algo = 'sha512',
        bool $testMode = false,
        string $culture = self::CULTURE_RU)
    {
        $this->login = $login;
        $this->paymentPassword = $paymentPassword;
        $this->validationPassword = $validationPassword;
        $this->algo = $algo;
        $this->isTestMode = $testMode;
        $this->culture = $culture;
    }

    /**
     * Create payment url.
     *
     * @throws EmptyDescriptionException if description is empty or not provided
     * @throws InvalidInvoiceIdException if invoice ID less or equals zero or not provided
     * @throws InvalidSumException if sum less or equals zero
     */
    public function getPaymentUrl(Payment $payment): string
    {
        if ($payment->getAmount() <= 0) {
            throw new InvalidSumException();
        }

        if (empty($payment->getDescription())) {
            throw new EmptyDescriptionException();
        }

        if ($payment->getNumber() <= 0) {
            throw new InvalidInvoiceIdException();
        }

        $signature = vsprintf('%s:%01.2f:%u:%s', [
            // '$login:$OutSum:$InvId:$passwordPayment'
            $this->login,
            $payment->getAmount(),
            $payment->getNumber(),
            $this->paymentPassword
        ]);

        $customParams = $payment->getCustomParams();
        if ($customParams) {
            // sort customParams alphabetically
            ksort($customParams);
            $signature .= ':' . http_build_query($customParams);
        }

        $data = $this->getData($payment);
        $data['SignatureValue'] = hash($this->algo, $signature);

        $data = http_build_query($data, '', '&');
        $custom = http_build_query($customParams, '', '&');

        return $this->baseUrl . $data . ($custom ? '&' . $custom : '');
    }

    private function getData(Payment $payment): array
    {
        return [
            'MerchantLogin' => $this->login,
            'InvId' => $payment->getNumber(),
            'OutSum' => $payment->getAmount(),
            'Desc' => $payment->getDescription(),
            'Culture' => $payment->getCulture() ?: $this->culture,
            'IncCurrLabel' => $payment->getCurrencyLabel(),
            'Email' => $payment->getEmail(),
            'Encoding' => 'utf-8',
            'IsTest' => $this->isTestMode
        ];
    }

    /**
     * Validates the Robokassa query.
     */
    public function validate(array $data): bool
    {
        $this->data = $data;

        $password = $this->validationPassword;

        $signature = vsprintf('%s:%u:%s%s', [
            // '$OutSum:$InvId:$password[:$params]'
            $data['OutSum'],
            $data['InvId'],
            $password,
            $this->getCustomParamsString($this->data)
        ]);

        $valid = (hash($this->algo, $signature) === strtolower($data['SignatureValue']));

        return $valid;
    }

    public function getSuccessAnswer(int $invoiceId): string
    {
        return 'OK' . $invoiceId . "\n";
    }

    private function getCustomParamsString(array $source): string
    {
        $params = [];

        foreach ($source as $key => $val) {
            if (stripos($key, 'shp_') === 0) {
                $params[$key] = $val;
            }
        }

        ksort($params);
        $params = http_build_query($params);

        return $params ? ':' . $params : '';
    }
}
