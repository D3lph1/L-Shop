<?php
declare(strict_types = 1);

namespace App\Services\Url\Signing;

class Signed
{
    /**
     * @var string
     */
    private $signature;

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var \DateTimeImmutable|null
     */
    private $expiredAt;

    public function __construct(string $signature, array $parameters = [])
    {
        $this->signature = $signature;
        $this->parameters = $parameters;
    }

    public function getExpiredAt(): ?\DateTimeImmutable
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(\DateTimeImmutable $at)
    {
        $this->expiredAt = $at;

        return $this;
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
