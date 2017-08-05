<?php

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
 *
 * @package  Idma\Robokassa
 */
class Checkout
{
    const CULTURE_EN = 'en';
    const CULTURE_RU = 'ru';
    private $culture;

    private $baseUrl = 'http://auth.robokassa.ru/Merchant/Index.aspx?';
    private $isTestMode = false;
    private $algo = 'sha512';
    private $data;

    private $login;
    private $paymentPassword;
    private $validationPassword;

    /**
     * Class constructor.
     *
     * @param  string $login              login of Merchant
     * @param  string $paymentPassword    password #1
     * @param  string $validationPassword password #2
     * @param  string $algo               hashing algo
     * @param  bool   $testMode           use test server
     * @param string  $culture
     */
    public function __construct($login, $paymentPassword, $validationPassword, $algo = 'sha512', $testMode = false, $culture = self::CULTURE_RU)
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
     * @param Payment $payment
     *
     * @return string if sum less or equals zero
     * @throws EmptyDescriptionException if description is empty or not provided
     * @throws InvalidInvoiceIdException if invoice ID less or equals zero or not provided
     * @throws InvalidSumException if sum less or equals zero
     */
    public function getPaymentUrl(Payment $payment)
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
            $signature .= ':' . http_build_query($customParams, null, ':');
        }

        $data = $this->getData($payment);
        $data['SignatureValue'] = hash($this->algo, $signature);

        $data = http_build_query($data, null, '&');
        $custom = http_build_query($customParams, null, '&');

        return $this->baseUrl . $data . ($custom ? '&' . $custom : '');
    }

    /**
     * @param Payment $payment
     *
     * @return array
     */
    private function getData(Payment $payment)
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
     *
     * @param  array  $data         query data
     *
     * @return bool
     */
    public function validate($data)
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

    /**
     * @param int $invoiceId
     *
     * @return string
     */
    public function getSuccessAnswer($invoiceId)
    {
        return 'OK' . $invoiceId . "\n";
    }

    private function getCustomParamsString(array $source)
    {
        $params = [];

        foreach ($source as $key => $val) {
            if (stripos($key, 'shp_') === 0) {
                $params[$key] = $val;
            }
        }

        ksort($params);
        $params = http_build_query($params, null, ':');

        return $params ? ':' . $params : '';
    }
}
