<?php
declare(strict_types = 1);

namespace App\Repository\Persistence;

use App\Entity\Persistence;
use App\Entity\User;

interface PersistenceRepository
{
    public function create(Persistence $persistence): void;

    public function deleteAll(): bool;

    public function findByCode(string $code): ?Persistence;

    public function findByUser(User $user): array;

    public function deleteByCode(string $code): bool;

    public function deleteByUser(User $user): bool;
}
