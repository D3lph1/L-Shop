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

use App\Services\Payments\Robokassa\Exception\InvalidSumException;
use App\Services\Payments\Robokassa\Exception\InvalidParamException;
use App\Services\Payments\Robokassa\Exception\InvalidInvoiceIdException;
use App\Services\Payments\Robokassa\Exception\EmptyDescriptionException;

/**
 * Class Payment
 *
 * @author JhaoDa <jhaoda@gmail.com>
 * @modified by D3lph1 <d3lph1.contact@gmail.com> special for L-shop project (https://github.com/D3lph1/L-shop)
 *
 * @package Idma\Robokassa
 */
class Payment {
    const CULTURE_EN = 'en';
    const CULTURE_RU = 'ru';

    private $baseUrl      = 'http://auth.robokassa.ru/Merchant/Index.aspx?';
    private $isTestMode   = false;
    private $valid        = false;
    private $algo         = 'sha512';
    private $data;
    private $customParams = [];

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
        $this->login              = $login;
        $this->paymentPassword    = $paymentPassword;
        $this->validationPassword = $validationPassword;
        $this->algo               = $algo;
        $this->isTestMode         = $testMode;

        $this->data = [
            'MerchantLogin'  => $this->login,
            'InvId'          => null,
            'OutSum'         => 0,
            'Desc'           => null,
            'SignatureValue' => '',
            'Encoding'       => 'utf-8',
            'Culture'        => self::CULTURE_RU,
            'IncCurrLabel'   => '',
            'IsTest'         => $testMode ? 1 : 0
        ];
    }

    /**
     * Create payment url.
     *
     * @throws InvalidSumException       if sum less or equals zero
     * @throws EmptyDescriptionException if description is empty or not provided
     * @throws InvalidInvoiceIdException if invoice ID less or equals zero or not provided
     *
     * @return string the payment url
     */
    public function getPaymentUrl()
    {
        if ($this->data['OutSum'] <= 0) {
            throw new InvalidSumException();
        }

        if (empty($this->data['Desc'])) {
            throw new EmptyDescriptionException();
        }

        if ($this->data['InvId'] <= 0) {
            throw new InvalidInvoiceIdException();
        }

        $signature = vsprintf('%s:%01.2f:%u:%s', [
            // '$login:$OutSum:$InvId:$passwordPayment'
            $this->login,
            $this->data['OutSum'],
            $this->data['InvId'],
            $this->paymentPassword
        ]);

        if ($this->customParams) {
            // sort params alphabetically
            ksort($this->customParams);
            $signature .= ':' . http_build_query($this->customParams, null, ':');
        }

        $this->data['SignatureValue'] = hash($this->algo, $signature);

        $data   = http_build_query($this->data, null, '&');
        $custom = http_build_query($this->customParams, null, '&');

        return $this->baseUrl . $data . ($custom ? '&' . $custom : '');
    }

    /**
     * Validates on ResultURL.
     *
     * @param  string $data query data
     *
     * @return bool
     */
    public function validateResult($data)
    {
        return $this->validate($data);
    }

    /**
     * Validates on SuccessURL.
     *
     * @param  string $data query data
     *
     * @return bool
     */
    public function validateSuccess($data)
    {
        return $this->validate($data, 'payment');
    }

    /**
     * Validates the Robokassa query.
     *
     * @param  string $data         query data
     * @param  string $passwordType type of password, 'validation' or 'payment'
     *
     * @return bool
     */
    private function validate($data, $passwordType = 'validation')
    {
        $this->data = $data;

        $password = $this->{$passwordType . 'Password'};

        $signature = vsprintf('%s:%u:%s%s', [
            // '$OutSum:$InvId:$password[:$params]'
            $data['OutSum'],
            $data['InvId'],
            $password,
            $this->getCustomParamsString($this->data)
        ]);

        $this->valid = (hash($this->algo, $signature) === strtolower($data['SignatureValue']));

        return $this->valid;
    }

    /**
     * Returns whether the Robokassa query is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * Adds custom parameters in payment.
     * The 'shp_' prefix will be added automatically.
     *
     * @param  array $params custom parameters array
     *
     * @throws InvalidParamException if params is not an array
     *
     * @return Payment
     */
    public function addCustomParameters($params)
    {
        if (!is_array($params)) {
            throw new InvalidParamException();
        }

        foreach ($params as $key => $val) {
            $this->customParams['shp_' . $key] = $val;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSuccessAnswer() {
        return 'OK' . $this->getInvoiceId() . "\n";
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

    /**
     * Get custom parameter from payment data.
     *
     * @param  string  $name  parameter name without "shp_"
     *
     * @return mixed
     */
    public function getCustomParam($name)
    {
        $key = 'shp_' . $name;

        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return null;
    }

    /**
     * @return int
     */
    public function getInvoiceId()
    {
        return $this->data['InvId'];
    }

    /**
     * @param $id
     *
     * @return Payment
     */
    public function setInvoiceId($id)
    {
        $this->data['InvId'] = (int) $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSum()
    {
        return $this->data['OutSum'];
    }

    /**
     * @param  mixed $summ
     *
     * @throws InvalidSumException
     *
     * @return Payment
     */
    public function setSum($summ)
    {
        $summ = number_format($summ, 2, '.', '');

        if ($summ > 0) {
            $this->data['OutSum'] = $summ;

            return $this;
        } else {
            throw new InvalidSumException();
        }
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->data['Desc'];
    }

    /**
     * @param  string $description
     *
     * @return Payment
     */
    public function setDescription($description)
    {
        $this->data['Desc'] = (string) $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getCulture()
    {
        return $this->data['Culture'];
    }

    /**
     * @param  string $culture
     *
     * @return Payment
     */
    public function setCulture($culture = self::CULTURE_RU)
    {
        $this->data['Culture'] = (string) $culture;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyLabel()
    {
        return $this->data['IncCurrLabel'];
    }

    /**
     * @param  string $currLabel
     *
     * @return Payment
     */
    public function setCurrencyLabel($currLabel)
    {
        $this->data['IncCurrLabel'] = (string) $currLabel;

        return $this;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->data['Email'] = $email;

        return $this;
    }

}
