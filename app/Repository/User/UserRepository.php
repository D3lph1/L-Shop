<?php
declare(strict_types = 1);

namespace App\Repository\User;

use App\Entity\User;

interface UserRepository
{
    public function create(User $user): void;

    public function update(User $user): void;

    public function deleteAll(): bool;

    public function findById(int $id): ?User;

    public function findByUsername(string $username): ?User;

    public function findByEmail(string $email): ?User;
}
