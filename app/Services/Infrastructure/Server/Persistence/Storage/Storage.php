<?php
declare(strict_types = 1);

namespace App\Services\Infrastructure\Server\Persistence\Storage;

interface Storage
{
    public function persist(int $serverId): void;

    public function retrieve(): ?int;
}
