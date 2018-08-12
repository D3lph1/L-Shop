<?php
declare(strict_types = 1);

namespace App\Services\Cart\Storage;

use Illuminate\Session\Store;

/**
 * Class Session
 * Implements the logic of storing the shopping cart data in a session.
 */
class Session implements Storage
{
    /**
     * @var Store
     */
    private $session;

    /**
     * Storage key.
     *
     * @var string
     */
    private $key = 'cart';

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function put(int $serverId, int $productId, int $amount): void
    {
        $server = $this->retrieveServer($serverId);

        if ($server === null) {
            $server = [];
        }

        $server[$productId] = $amount;
        $this->session->put("{$this->key}.{$serverId}", $server);
    }

    /**
     * {@inheritdoc}
     */
    public function retrieve(int $serverId, int $productId): ?int
    {
        return $this->session->get("{$this->key}.{$serverId}.{$productId}");
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveServer(int $serverId): ?array
    {
        return $this->session->get("{$this->key}.{$serverId}");
    }

    /**
     * {@inheritdoc}
     */
    public function remove(int $serverId, int $productId): bool
    {
        return (bool)$this->session->remove("{$this->key}.{$serverId}.{$productId}");
    }

    /**
     * {@inheritdoc}
     */
    public function removeServer(int $serverId): bool
    {
        return (bool)$this->session->remove("{$this->key}.{$serverId}");
    }

    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
