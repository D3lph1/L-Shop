<?php
declare(strict_types = 1);

namespace App\Services\Payments\Interkassa;

use App\Exceptions\Payment\Interkassa\EmptyDescriptionException;
use App\Exceptions\Payment\Interkassa\UnexpectedStatusException;
use App\Exceptions\Payment\Interkassa\UnknownCheckoutException;

/**
 * Class Checkout
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Payments\Interkassa
 */
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
     */
    public function __construct(string $id, string $key, ?string $testKey, bool $isTest = false, string $algo = 'sha256')
    {
        $this->id = $id;
        $this->key = $key;
        $this->testKey = $testKey;
        $this->isTest = (bool)$isTest;
        $this->algo = $algo;
    }

    public function getPaymentUrl(Payment $payment): string
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

    protected function buildArray(Payment $payment): array
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

    protected function filterArray(array $arr): array
    {
        $filtered = array_filter($arr);
        foreach ($filtered as &$item) {
            if (is_array($item)) {
                $item = implode(';', $item);
            }
        }

        return $filtered;
    }

    public function validate(array $request): bool
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

    public function getSuccessAnswer(): string
    {
        return 'OK';
    }

    protected function key(): ?string
    {
        return $this->isTest() ? $this->getTestKey() : $this->getKey();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getTestKey(): ?string
    {
        return $this->testKey;
    }

    public function isTest(): bool
    {
        return $this->isTest;
    }
}
