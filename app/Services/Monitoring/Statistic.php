<?php
declare(strict_types = 1);

namespace App\Services\Monitoring;

use App\Entity\Server;

class Statistic
{
    /**
     * @var Server
     */
    private $server;

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

    public function __construct(Server $server, int $now, int $total, bool $disabled = false, bool $failed = false)
    {
        $this->server = $server;
        $this->now = $now;
        $this->total = $total;
        $this->disabled = $disabled;
        $this->failed = $failed;
    }

    /**
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
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
