<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Users\Edit;

use App\Entity\Ban as Entity;
use App\Services\DateTime\Formatting\JavaScriptFormatter;

class Ban implements \JsonSerializable
{
    /**
     * @var Entity
     */
    private $ban;

    /**
     * @var bool
     */
    private $expired;

    public function __construct(Entity $ban, bool $expired)
    {
        $this->ban = $ban;
        $this->expired = $expired;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        $formatter = new JavaScriptFormatter();

        return [
            'id' => $this->ban->getId(),
            'createdAt' => $formatter->format($this->ban->getCreatedAt()),
            'until' => $this->ban->getUntil() !== null ? $formatter->format($this->ban->getUntil()) : null,
            'reason' => $this->ban->getReason(),
            'expired' => $this->expired
        ];
    }
}
