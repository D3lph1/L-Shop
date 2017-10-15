<?php
declare(strict_types = 1);

namespace App\DataTransferObjects;

use Carbon\Carbon;

/**
 * Class Ban
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\DataTransferObjects
 */
class Ban
{
    private $userId;

    private $until;

    private $reason;

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUntil(?Carbon $until): self
    {
        $this->until = $until;

        return $this;
    }

    public function getUntil(): ?Carbon
    {
        return $this->until;
    }

    public function setReason(?string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }
}
