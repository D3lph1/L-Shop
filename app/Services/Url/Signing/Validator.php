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
    private $delimiter;

    public function __construct(string $algorithm, string $key, ?string $delimiter = '')
    {
        $this->algorithm = $algorithm;
        $this->key = $key;

        if (empty($delimiter)) {
            $delimiter = '';
        }
        $this->delimiter = $delimiter;
    }

    public function validate(Signed $signed): bool
    {
        $parameters = $signed->getParameters();
        // Sort parameters in alphabetical order.
        ksort($parameters);
        // If this url has may expire.
        if ($signed->getExpiredAt() !== null) {
            // Add expired timestamp as penultimate parameter.
            $parameters['expired'] = $signed->getExpiredAt()->getTimestamp();
        }
        // Add API key as last parameter. It is necessary to to generate signature.
        $parameters['key'] = $this->key;

        // Join parameters in string. Between each parameter is the line delimiter.
        // Example for ':' delimiter: 'param1:param2:param3:secretKey'
        $signatureContent = implode($this->delimiter, $parameters);
        // Create hash from signature string.
        $signature = hash($this->algorithm, $signatureContent);

        // Compare given and constructed hashes.
        if (mb_strtolower($signature) !== mb_strtolower($signed->getSignature())) {
            return false;
        }

        // If this url has may expire.
        if ($signed->getExpiredAt() !== null) {
            // If expired.
            if ($signed->getExpiredAt()->diff(new \DateTimeImmutable())->invert === 0) {
                return false;
            }
        }

        return true;
    }
}
