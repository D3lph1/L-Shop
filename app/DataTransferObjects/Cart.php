<?php
declare(strict_types = 1);

namespace App\DataTransferObjects;

/**
 * Class Cart
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\DataTransferObjects
 */
class Cart
{
    /**
     * @var int
     */
    private $serverId;

    /**
     * @var string
     */
    private $player;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $item;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $extra;

    /**
     * @var int
     */
    private $itemId;

    public function setServerId(int $serverId): self
    {
        $this->serverId = $serverId;

        return $this;
    }

    public function getServerId(): int
    {
        return $this->serverId;
    }

    public function setPlayer(string $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getPlayer(): string
    {
        return $this->player;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setItem(string $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getItem(): string
    {
        return $this->item;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setExtra(string $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    public function getExtra(): ?string
    {
        return $this->extra;
    }

    public function setItemId(int $itemId): self
    {
        $this->itemId = $itemId;

        return $this;
    }

    public function getItemId(): int
    {
        return $this->itemId;
    }
}
