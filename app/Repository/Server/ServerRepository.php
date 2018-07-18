<?php
declare(strict_types = 1);

namespace App\Repository\Server;

use App\Entity\Server;

interface ServerRepository
{
    public function create(Server $server): void;

    public function update(Server $server): void;

    public function remove(Server $server): void;

    public function deleteAll(): bool;

    public function find(int $id): ?Server;

    /**
     * @return Server[]
     */
    public function findWithEnabledMonitoring(): array;

    public function findAll(): array;

    public function findAllWithCategories(): array;
}
