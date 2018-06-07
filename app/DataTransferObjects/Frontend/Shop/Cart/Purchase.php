<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Shop\Cart;

class Purchase
{
    /**
     * @var int
     */
    private $serverId;

    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var array
     */
    private $items;

    /**
     * @return int
     */
    public function getServerId(): int
    {
        return $this->serverId;
    }

    /**
     * @param int $serverId
     *
     * @return Purchase
     */
    public function setServerId(int $serverId): Purchase
    {
        $this->serverId = $serverId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param null|string $username
     *
     * @return Purchase
     */
    public function setUsername(?string $username): Purchase
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     *
     * @return Purchase
     */
    public function setIp(string $ip): Purchase
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     *
     * @return Purchase
     */
    public function setItems(array $items): Purchase
    {
        $this->items = $items;

        return $this;
    }
}
