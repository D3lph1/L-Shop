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

        // Join parameters in string. Between each parameter is the line separator.
        // Example for ':' separator: 'param1:param2:param3:secretKey'
        $signatureContent = implode($this->separator, $parameters);
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
