<?php
declare(strict_types = 1);

namespace App\Services\Server\Persistence\Storage;

use Illuminate\Contracts\Session\Session as Store;

class Session implements Storage
{
    /**
     * @var Store
     */
    private $session;

    private $key = 'server';

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function persist(int $serverId): void
    {
        $this->session->put($this->key, $serverId);
    }

    public function retrieve(): ?int
    {
        return $this->session->get($this->key);
    }

    public function remove(): void
    {
        $this->session->remove($this->key);
    }
}
