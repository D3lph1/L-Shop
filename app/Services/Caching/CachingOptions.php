<?php
declare(strict_types = 1);

namespace App\Services\Caching;

class CachingOptions
{
    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var int
     */
    private $lifetime = 0;

    public function __construct(bool $enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return int
     */
    public function getLifetime(): int
    {
        return $this->lifetime;
    }

    /**
     * @param int $lifetime
     *
     * @return CachingOptions
     */
    public function setLifetime(int $lifetime): CachingOptions
    {
        $this->lifetime = $lifetime;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
