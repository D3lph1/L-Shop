<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Entity\Ban;
use App\Entity\User;
use App\Repository\User\UserRepository;
use App\Services\DateTime\DateTimeUtil;

class BanManager
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isExpired(Ban $ban): bool
    {
        if ($ban->getUntil() === null) {
            return false;
        }

        return $ban->getUntil()->diff(new \DateTimeImmutable())->invert === 0;
    }

    public function isPermanent(Ban $ban): bool
    {
        return $ban->getUntil() === null;
    }

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
     * @param User $user
     *
     * @return Ban[]
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

    public function banUntil(User $user, \DateTimeImmutable $until, ?string $reason = null): Ban
    {
        $ban = (new Ban($user, $until))
            ->setReason($reason);
        $user->addBan($ban);
        $this->userRepository->update($user);

        return $ban;
    }

    public function banForDays(User $user, int $days, ?string $reason = null): Ban
    {
        return $this->banUntil($user, DateTimeUtil::nowAdd($days * 60 * 24), $reason);
    }

    public function permanently(User $user, ?string $reason): Ban
    {
        $ban = (new Ban($user, null))
            ->setReason($reason);
        $user->addBan($ban);
        $this->userRepository->update($user);

        return $ban;
    }

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
