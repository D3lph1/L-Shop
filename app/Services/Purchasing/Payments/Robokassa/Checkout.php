<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Payments\Robokassa;

use App\Exceptions\UnexpectedValueException;

class Checkout
{
    private const URL = 'http://auth.robokassa.ru/Merchant/Index.aspx?';

    const CULTURE_EN = 'en';

    const CULTURE_RU = 'ru';

    /**
     * @var string
     */
    private $culture;

    /**
     * @var bool
     */
    private $testMode = false;

    /**
     * @var string
     */
    private $algorithm;

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
     *
     * @param string $login
     * @param string $paymentPassword
     * @param string $validationPassword
     * @param string $algorithm
     * @param bool   $testMode
     * @param string $culture
     */
    public function __construct(
        string $login,
        string $paymentPassword,
        string $validationPassword,
        string $algorithm = 'sha512',
        bool $testMode = false,
        string $culture = self::CULTURE_RU)
    {
        $this->login = $login;
        $this->paymentPassword = $paymentPassword;
        $this->validationPassword = $validationPassword;
        $this->algorithm = $algorithm;
        $this->testMode = $testMode;
        $this->culture = $culture;
    }

    /**
     * Create payment url.
     *
     * @param Payment $payment
     *
     * @return string
     */
    public function paymentUrl(Payment $payment): string
    {
        if ($payment->getAmount() <= 0) {
            throw new UnexpectedValueException('Amount is invalid');
        }
        if (empty($payment->getDescription())) {
            throw new UnexpectedValueException('Description is empty');
        }
        if ($payment->getNumber() <= 0) {
            throw new UnexpectedValueException('Number is invalid');
        }
        $signature = vsprintf('%s:%01.2f:%u:%s', [
            // 'login:OutSum:InvId:passwordPayment'
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
        $data['SignatureValue'] = hash($this->algorithm, $signature);
        $data = http_build_query($data, '', '&');
        $custom = http_build_query($customParams, '', '&');
        return self::URL . $data . ($custom ? '&' . $custom : '');
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
            'IsTest' => $this->testMode
        ];
    }

    /**
     * Validates the Robokassa query.
     *
     * @param array $data
     *
     * @return bool
     */
    public function validate(array $data): bool
    {
        $this->data = $data;
        $password = $this->validationPassword;
        $signature = vsprintf('%s:%u:%s%s', [
            // 'OutSum:InvId:password[:params]'
            $data['OutSum'],
            $data['InvId'],
            $password,
            $this->getCustomParamsString($this->data)
        ]);
        $valid = (hash($this->algorithm, $signature) === strtolower($data['SignatureValue']));
        return $valid;
    }

    public function getSuccessAnswer(int $invoiceId): string
    {
        return "OK{$invoiceId}\n";
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
