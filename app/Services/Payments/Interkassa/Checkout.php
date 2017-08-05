<?php

namespace App\Services\Payments\Interkassa;

use App\Exceptions\Payment\Interkassa\EmptyDescriptionException;
use App\Exceptions\Payment\Interkassa\UnexpectedStatusException;
use App\Exceptions\Payment\Interkassa\UnknownCheckoutException;

class Checkout
{
    protected $url = 'https://sci.interkassa.com';

    /**
     * @var string Checkout identifier.
     */
    protected $id;

    /**
     * @var string Sign key.
     */
    protected $key;

    /**
     * @var string Sign test key.
     */
    protected $testKey;

    /**
     * @var bool
     */
    protected $isTest;

    /**
     * @var string
     */
    protected $algo;

    /**
     * Checkout constructor.
     *
     * @param string $id      Checkout identifier.
     * @param string $key     Sign key.
     * @param string $testKey Sign test key.
     * @param bool   $isTest
     * @param string $algo
     */
    public function __construct($id, $key, $testKey, $isTest = false, $algo = 'sha256')
    {
        $this->id = $id;
        $this->key = $key;
        $this->testKey = $testKey;
        $this->isTest = (bool)$isTest;
        $this->algo = $algo;
    }

    /**
     * @param Payment $payment
     *
     * @return string Payment reference(link).
     */
    public function getPaymentUrl(Payment $payment)
    {
        if (empty($payment->getDescription())) {
            throw new EmptyDescriptionException();
        }

        $array = $this->buildArray($payment);
        $array['ik_co_id'] = $this->getId();
        ksort($array);
        $key = $this->getKey();
        array_push($array, $key);
        $signature = implode(':', $array);
        $hash = base64_encode(hash($this->algo, $signature, true));
        array_pop($array);
        $array['ik_sign'] = $hash;

        return $this->url . '?' . http_build_query($array);
    }

    /**
     * @param Payment $payment
     *
     * @return array
     */
    protected function buildArray(Payment $payment)
    {
        $arr = [
            'ik_co_id' => $this->getId(),
            'ik_pm_no' => $payment->getNumber(),
            'ik_cur' => $payment->getCurrency(),
            'ik_am' => $payment->getAmount(),
            'ik_am_t' => $payment->getAmountType(),
            'ik_desc' => $payment->getDescription(),
            'ik_exp' => $payment->getExpired(),
            'ik_ltm' => $payment->getLifetime(),
            'ik_pw_on' => $payment->getPaywayOn(),
            'ik_pw_off' => $payment->getPaywayOff(),
            'ik_pw_via' => $payment->getPaywayVia(),
            'ik_loc' => $payment->getLocale(),
        ];

        $arr = array_merge($arr, $payment->getCustomParams());

        return $this->filterArray($arr);
    }

    /**
     * @param array $arr
     *
     * @return array
     */
    protected function filterArray(array $arr)
    {
        $filtered = array_filter($arr);
        foreach ($filtered as &$item) {
            if (is_array($item)) {
                $item = implode(';', $item);
            }
        }

        return $filtered;
    }

    /**
     * @param array $request
     *
     * @return bool
     * @throws UnknownCheckoutException
     * @throws UnexpectedStatusException
     */
    public function validate(array $request)
    {
        if ($request['ik_co_id'] !== s_get('payment.method.interkassa.checkout_id')) {
            throw new UnknownCheckoutException($request['ik_co_id']);
        }

        if ($request['ik_inv_st'] !== 'success') {
            throw new UnexpectedStatusException($request['ik_inv_st']);
        }

        $sign = $request['ik_sign'];
        unset($request['ik_sign']);
        ksort($request);
        $key = $this->key();
        array_push($request, $key);
        $signature = implode(':', $request);
        $hash = base64_encode(hash($this->algo, $signature, true));

        return $hash === $sign;
    }

    public function getSuccessAnswer()
    {
        return 'OK';
    }

    protected function key()
    {
        return $this->isTest() ? $this->getTestKey() : $this->getKey();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getTestKey()
    {
        return $this->testKey;
    }

    /**
     * @return bool
     */
    public function isTest()
    {
        return $this->isTest;
    }
}
