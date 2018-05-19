<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Entity\Ban;
use App\Entity\User;
use App\Repository\User\UserRepository;
use App\Services\DateTime\DateTimeUtil;

class DefaultBanManager implements BanManager
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function isExpired(Ban $ban): bool
    {
        if ($ban->getUntil() === null) {
            return false;
        }

        return $ban->getUntil()->diff(new \DateTimeImmutable())->invert === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isPermanent(Ban $ban): bool
    {
        return $ban->getUntil() === null;
    }

    /**
     * {@inheritdoc}
     */
    public function isPermanently(User $user): bool
    {
        /** @var Ban $ban */
        foreach ($user->getBans() as $ban) {
            if (!$this->isExpired($ban) && $this->isPermanent($ban)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function notExpired(User $user): array
    {
        $result = [];
        /** @var Ban $ban */
        foreach ($user->getBans() as $ban) {
            if (!$this->isExpired($ban)) {
                $result[] = $ban;
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function isBanned(User $user): bool
    {
        /** @var Ban $ban */
        foreach ($user->getBans() as $ban) {
            if (!$this->isExpired($ban)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function banUntil(User $user, \DateTimeImmutable $until, ?string $reason = null): Ban
    {
        $ban = (new Ban($user, $until))
            ->setReason($reason);
        $user->getBans()->add($ban);
        $this->userRepository->update($user);

        return $ban;
    }

    /**
     * {@inheritdoc}
     */
    public function banFor(User $user, \DateInterval $interval, ?string $reason = null): Ban
    {
        return $this->banUntil($user, DateTimeUtil::nowAdd($interval), $reason);
    }

    /**
     * {@inheritdoc}
     */
    public function banForDays(User $user, int $days, ?string $reason = null): Ban
    {
        return $this->banUntil($user, DateTimeUtil::nowAddMinutes($days * 60 * 24), $reason);
    }

    /**
     * {@inheritdoc}
     */
    public function banPermanently(User $user, ?string $reason = null): Ban
    {
        $ban = (new Ban($user, null))
            ->setReason($reason);
        $user->getBans()->add($ban);
        $this->userRepository->update($user);

        return $ban;
    }

    /**
     * {@inheritdoc}
     */
    public function pardon(User $user): bool
    {
        if (!$this->isBanned($user)) {
            return false;
        }

        $f = false;
        /** @var Ban $ban */
        foreach ($user->getBans() as $ban) {
            if (!$this->isExpired($ban)) {
                $user->getBans()->removeElement($ban);
                $f = true;
            }
        }

        return $f;
    }
}
