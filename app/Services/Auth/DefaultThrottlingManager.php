<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Entity\Throttle;
use App\Entity\User;
use App\Repository\Throttle\ThrottleRepository;
use App\Services\Auth\Exceptions\ThrottlingException;
use App\Services\DateTime\DateTimeUtil;

class DefaultThrottlingManager implements ThrottlingManager
{
    /**
     * @var ThrottleRepository
     */
    private $repository;

    /**
     * @var ThrottlingOptions
     */
    private $options;

    public function __construct(ThrottleRepository $repository, ThrottlingOptions $options)
    {
        $this->repository = $repository;
        $this->options = $options;
    }

    public function logGlobal(): void
    {
        if ($this->options->getGlobalAttempts() <= 0) {
            return;
        }
        $this->repository->create(new Throttle(DateTimeUtil::nowAddSeconds($this->options->getGlobalCooldown())));
    }

    public function logIp(string $ip): void
    {
        if ($this->options->getIpAttempts() <= 0) {
            return;
        }
        $this->repository->create((new Throttle(DateTimeUtil::nowAddSeconds($this->options->getIpCooldown())))->setIp($ip));
    }

    public function logUser(User $user): void
    {
        if ($this->options->getUserAttempts() <= 0) {
            return;
        }
        $this->repository->create((new Throttle(DateTimeUtil::nowAddSeconds($this->options->getUserCooldown())))->setUser($user));
    }

    public function isGlobalBanned(): bool
    {
        if ($this->options->getGlobalAttempts() <= 0) {
            return false;
        }
        $count = $this->repository->countGlobalNotExpired(new \DateTimeImmutable());

        return $count >= $this->options->getGlobalAttempts();
    }

    public function maxGlobalExpiration(): \DateTimeImmutable
    {
        return $this->repository->minGlobalExpiration(new \DateTimeImmutable());
    }

    public function isIpBanned(string $ip): bool
    {
        if ($this->options->getIpAttempts() <= 0) {
            return false;
        }
        $count = $this->repository->countIpNotExpired($ip, new \DateTimeImmutable());

        return $count >= $this->options->getIpAttempts();
    }

    public function maxIpExpiration(string $ip): \DateTimeImmutable
    {
        return $this->repository->minGlobalAndIpExpiration($ip, new \DateTimeImmutable());
    }

    public function isUserBanned(User $user): bool
    {
        if ($this->options->getUserAttempts() <= 0) {
            return false;
        }
        $count = $this->repository->countUserNotExpired($user, new \DateTimeImmutable());

        return $count >= $this->options->getUserAttempts();
    }

    /**
     * @param string    $ip
     * @param User|null $user
     *
     * @throws ThrottlingException
     */
    public function throwIfBanned(string $ip, ?User $user = null): void
    {
        $global = $this->isGlobalBanned();
        $byIp = $this->isIpBanned($ip);

        $datetime = null;

        if ($user !== null) {
            $byUser = $this->isUserBanned($user);

            if ($global && $byIp && $byUser) {
                $datetime = $this->repository->minGlobalAndIpAndUserExpiration($ip, $user, new \DateTimeImmutable());
            }

            if ($global && $byUser) {
                $datetime = $this->repository->minGlobalAndUserExpiration($user, new \DateTimeImmutable());
            }

            if ($byIp && $byUser) {
                $datetime = $this->repository->minIpAndUserExpiration($ip, $user, new \DateTimeImmutable());
            }

            if ($byUser) {
                $datetime = $this->repository->minUserExpiration($user, new \DateTimeImmutable());
            }
        }

        if ($global && $byIp) {
            $datetime = $this->repository->minGlobalAndIpExpiration($ip, new \DateTimeImmutable());
        }

        if ($global) {
            $datetime = $this->repository->minGlobalExpiration(new \DateTimeImmutable());
        }

        if ($byIp) {
            $datetime = $this->repository->minIpExpiration($ip, new \DateTimeImmutable());
        }

        if ($datetime !== null) {
            throw new ThrottlingException((int)$datetime->format('U') - time());
        }
    }

    public function maxIpAndUserExpiration(string $ip, User $user): \DateTimeImmutable
    {
        return $this->repository->minGlobalAndIpAndUserExpiration($ip, $user, new \DateTimeImmutable());
    }
}
