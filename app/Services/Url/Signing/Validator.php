<?php
declare(strict_types = 1);

namespace App\Services\Url\Signing;

class Validator
{
    /**
     * @var string
     */
    private $algorithm;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $separator;

    public function __construct(string $algorithm, string $key, ?string $separator = '')
    {
        $this->algorithm = $algorithm;
        $this->key = $key;

        if (empty($separator)) {
            $separator = '';
        }
        $this->separator = $separator;
    }

    public function validate(Signed $signed): bool
    {
        $parameters = $signed->getParameters();
        ksort($parameters);
        if ($signed->getExpiredAt() !== null) {
            $parameters['expired'] = $signed->getExpiredAt()->getTimestamp();
        }
        $parameters['key'] = $this->key;
        $signatureContent = implode($this->separator, $parameters);
        $signature = hash($this->algorithm, $signatureContent);

        if (mb_strtolower($signature) !== mb_strtolower($signed->getSignature())) {
            return false;
        }

        if ($signed->getExpiredAt() !== null) {
            if ($signed->getExpiredAt()->diff(new \DateTimeImmutable())->invert === 0) {
                return false;
            }
        }

        return true;
    }
}
