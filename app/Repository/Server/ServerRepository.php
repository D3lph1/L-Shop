<?php
declare(strict_types = 1);

namespace App\Repository\Server;

use App\Entity\Server;

interface ServerRepository
{
    public function create(Server $server): void;

    public function deleteAll(): bool;

    public function findAll(): array;

    public function find(int $id): ?Server;
}
