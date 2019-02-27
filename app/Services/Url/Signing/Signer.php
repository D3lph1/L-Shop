<?php
declare(strict_types = 1);

namespace App\Services\Url\Signing;

class Signer
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

    /**
     * Creates signed url.
     *
     * @param Signable $dto
     *
     * @return string
     */
    public function create(Signable $dto): string
    {
        $parameters = $dto->getParameters();
        // Sort parameters in alphabetical order.
        ksort($parameters);
        // If this url has may expire.
        if ($dto->getExpiredAt() !== null) {
            // Add expired timestamp as penultimate parameter.
            $parameters['expired'] = $dto->getExpiredAt()->getTimestamp();
        }
        // Add API key as last parameter. It is necessary to to generate signature.
        $parameters['key'] = $this->key;

        // Join parameters in string. Between each parameter is the line delimiter.
        // Example for ':' delimiter: 'param1:param2:param3:secretKey'
        $signatureContent = implode($this->delimiter, $parameters);
        // Create hash from signature string.
        $signature = hash($this->algorithm, $signatureContent);
        // Remove key from parameters. It is very important.
        unset($parameters['key']);
        // The signature must be present in the resulting set of parameters.
        $parameters = array_merge($parameters, [
            'signature' => $signature
        ]);

        return $dto->getUrl() . '?' . http_build_query($parameters);
    }
}
