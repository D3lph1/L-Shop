<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Entity\User;

interface ThrottlingManager
{
    public function logGlobal(): void;

    public function logIp(string $ip): void;

    public function logUser(User $user): void;

    public function isGlobalBanned(): bool;

    public function maxGlobalExpiration(): \DateTimeImmutable;

    public function isIpBanned(string $ip): bool;

    public function maxIpExpiration(string $ip): \DateTimeImmutable;

    public function isUserBanned(User $user): bool;

    public function throwIfBanned(string $ip, User $user): void;

    public function maxIpAndUserExpiration(string $ip, User $user): \DateTimeImmutable;
}
