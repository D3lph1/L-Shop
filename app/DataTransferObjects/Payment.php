<?php
declare(strict_types = 1);

namespace App\DataTransferObjects;

use App\Exceptions\InvalidArgumentTypeException;

/**
 * Class Payment
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\DataTransferObjects
 */
class Payment
{
    /**
     * @var string
     */
    private $service;

    /**
     * @var string
     */
    private $products;

    /**
     * @var float
     */
    private $cost;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $username;

    /**
     * @var int
     */
    private $serverId;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var bool
     */
    private $completed;

    public function setService(string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setProducts($products): self
    {
        if (is_array($products)) {
            $this->products = is_null($products) ? null : json_encode($products);
        } else if (is_string($products)) {
            $this->products = $products;
        } else if (is_null($products)) {
            $this->products = null;
        } else {
            throw new InvalidArgumentTypeException(['array', 'string'], $products);
        }

        return $this;
    }

    public function getProducts(): ?string
    {
        return $this->products;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getCost(): float
    {
        return $this->cost;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setServerId(int $serverId): self
    {
        $this->serverId = $serverId;

        return $this;
    }

    public function getServerId(): int
    {
        return $this->serverId;
    }

    public function setIp(string $ip)
    {
        $this->ip = $ip;

        return $this;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }
}
