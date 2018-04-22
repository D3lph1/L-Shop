<?php
declare(strict_types = 1);

namespace App\Services\Url\Signing;

/**
 * Class Url
 * Represents data transfer object for signed url.
 */
class Signable
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var \DateTimeImmutable|null
     */
    private $expiredAt;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function addParameter(string $name, $value): Signable
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function expiredAt(\DateTimeImmutable $at): Signable
    {
        $this->expiredAt = $at;

        return $this;
    }

    public function getExpiredAt(): ?\DateTimeImmutable
    {
        return $this->expiredAt;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
