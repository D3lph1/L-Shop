<?php
declare(strict_types = 1);

namespace App\Repository\Activation;

use App\Entity\Activation;
use App\Entity\User;

interface ActivationRepository
{
    public function create(Activation $activation): void;

    public function update(Activation $activation): void;

    public function deleteAll(): bool;

    public function findByUser(User $user): array;

    public function findByCode(string $code): ?Activation;

    public function deleteByUser(User $user): void;
}
