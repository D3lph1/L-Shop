<?php
declare(strict_types = 1);

namespace App\Services\Monitoring\Drivers;

class DTO
{
    /**
     * @var int
     */
    private $now;

    /**
     * @var int
     */
    private $total;

    /**
     * @var bool
     */
    private $disabled;

    /**
     * @var bool
     */
    private $failed;

    public function __construct(int $now, int $total, bool $disabled = false, bool $failed = false)
    {
        $this->now = $now;
        $this->total = $total;
        $this->disabled = $disabled;
        $this->failed = $failed;
    }

    /**
     * @return int
     */
    public function getNow(): int
    {
        return $this->now;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->failed;
    }
}
