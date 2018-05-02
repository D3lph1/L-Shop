<?php
declare(strict_types = 1);

namespace App\Services\Monitoring\Drivers;

/**
 * Class DTO
 * The Data transfer object is used to transfer information between layers of the application.
 */
class DTO
{
    /**
     * How many players are on the server at the moment.
     *
     * @var int
     */
    private $now;

    /**
     * How many slots does the server have. (Maximum server capacity).
     *
     * @var int
     */
    private $total;

    /**
     * Is the server offline now?
     *
     * @var bool
     */
    private $disabled;

    /**
     * Did an error occur when you receive a response from a repository with statistics.
     *
     * @var bool
     */
    private $failed;

    /**
     * DTO constructor.
     *
     * @param int  $now      {@see DTO::$now}
     * @param int  $total    {@see DTO::$total}
     * @param bool $disabled {@see DTO::$disabled}
     * @param bool $failed   {@see DTO::$failed}
     */
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
