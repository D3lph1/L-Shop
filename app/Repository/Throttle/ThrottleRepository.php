<?php
declare(strict_types = 1);

namespace App\Repository\Throttle;

use App\Entity\Throttle;
use App\Entity\User;

interface ThrottleRepository
{
    public function create(Throttle $throttle): void;

    public function countGlobalNotExpired(\DateTimeImmutable $datetime): int;

    public function minGlobalExpiration(\DateTimeImmutable $datetime): ?\DateTimeImmutable;

    public function countIpNotExpired(string $ip, \DateTimeImmutable $datetime): int;

    public function minIpExpiration(string $ip, \DateTimeImmutable $datetime): ?\DateTimeImmutable;

    public function countUserNotExpired(User $user, \DateTimeImmutable $datetime): int;

    public function minUserExpiration(User $user, \DateTimeImmutable $datetime): ?\DateTimeImmutable;

    public function minGlobalAndIpAndUserExpiration(string $ip, User $user, \DateTimeImmutable $datetime): ?\DateTimeImmutable;

    public function minGlobalAndUserExpiration(User $user, \DateTimeImmutable $datetime): ?\DateTimeImmutable;

    public function minGlobalAndIpExpiration(string $ip, \DateTimeImmutable $datetime): ?\DateTimeImmutable;

    public function minIpAndUserExpiration(string $ip, User $user, \DateTimeImmutable $datetime): ?\DateTimeImmutable;

    public function deleteAll(): bool;
}
