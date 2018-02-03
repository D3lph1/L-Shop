<?php
declare(strict_types = 1);

namespace App\Services\Cart\Storage;

use Illuminate\Session\Store;

class Session implements Storage
{
    /**
     * @var Store
     */
    private $session;

    private $key = 'cart';

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function put(int $serverId, int $productId, float $amount): void
    {
        $server = $this->retrieveServer($serverId);

        if ($server === null) {
            $server = [];
        }

        $server[$productId] = $amount;
        $this->session->put("{$this->key}.{$serverId}", $server);
    }

    public function retrieve(int $serverId, int $productId): ?float
    {
        return $this->session->get("{$this->key}.{$serverId}.{$productId}");
    }

    public function retrieveServer(int $serverId): ?array
    {
        return $this->session->get("{$this->key}.{$serverId}");
    }

    public function remove(int $serverId, int $productId): bool
    {
        return (bool)$this->session->remove("{$this->key}.{$serverId}.{$productId}");
    }

    public function removeServer(int $serverId): bool
    {
        return (bool)$this->session->remove("{$this->key}.{$serverId}");
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
