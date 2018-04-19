<?php
declare(strict_types=1);

namespace App\Services\Purchasing\Payments\Interkassa;

use App\Exceptions\RuntimeException;
use App\Exceptions\UnexpectedValueException;

class Checkout
{
    private const URL = 'https://sci.interkassa.com';

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
     * @param string      $id
     * @param string      $key
     * @param null|string $testKey
     * @param string      $algo
     * @param bool        $test
     */
    public function __construct(string $id, string $key, ?string $testKey, string $algo = 'sha256', bool $test = false)
    {
        $this->id = $id;
        $this->key = $key;
        $this->testKey = $testKey;
        $this->isTest = $test;
        $this->algo = $algo;
    }

    public function paymentUrl(Payment $payment): string
    {
        if (empty($payment->getDescription())) {
            throw new UnexpectedValueException('Description is empty');
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

        return self::URL . '?' . http_build_query($array);
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
        if ($request['ik_co_id'] !== $this->id) {
            throw new UnexpectedValueException($request['ik_co_id']);
        }
        if ($request['ik_inv_st'] !== 'success') {
            throw new RuntimeException('Bad invoice status');
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

    public function successAnswer(): string
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
