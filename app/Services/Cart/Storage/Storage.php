<?php
declare(strict_types = 1);

namespace App\Services\Cart\Storage;

interface Storage
{
    public function put(int $serverId, int $productId, float $amount): void;

    public function retrieve(int $serverId, int $productId): ?float;

    public function retrieveServer(int $serverId): ?array;

    public function remove(int $serverId, int $productId): bool;

    public function removeServer(int $serverId): bool;

    public function getKey(): string;
}
