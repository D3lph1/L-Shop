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

    /**
     * Checks whether the passed ban is expired.
     *
     * @param Ban $ban Ban entity you want to check.
     *
     * @return bool
     */
    public function isExpired(Ban $ban): bool
    {
        if ($ban->getUntil() === null) {
            return false;
        }

        return $ban->getUntil()->diff(new \DateTimeImmutable())->invert === 0;
    }

    /**
     * Checks whether the passed ban is permanent.
     *
     * @param Ban $ban Ban entity you want to check.
     *
     * @return bool
     */
    public function isPermanent(Ban $ban): bool
    {
        return $ban->getUntil() === null;
    }

    /**
     * Checks whether the passed user is banned forever.
     *
     * @param User $user User you want to check.
     *
     * @return bool
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
     * Returns all non-expired user bans.
     *
     * @param User $user The user whose bans you want to receive.
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

    /**
     * Checks if the user is banned.
     *
     * @param User $user User you want to check.
     *
     * @return bool
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
     * Ban the user before the specified datetime.
     *
     * @param User               $user The user you want to ban.
     * @param \DateTimeImmutable $until Datetime when the ban ends.
     * @param null|string        $reason Reason of ban.
     *
     * @return Ban
     */
    public function banUntil(User $user, \DateTimeImmutable $until, ?string $reason = null): Ban
    {
        $ban = (new Ban($user, $until))
            ->setReason($reason);
        $user->addBan($ban);
        $this->userRepository->update($user);

        return $ban;
    }

    /**
     * Ban the user for a certain period of time.
     *
     * @param User          $user The user you want to ban.
     * @param \DateInterval $interval Duration of blocking.
     * @param null|string   $reason Reason of ban.
     *
     * @return Ban
     */
    public function banFor(User $user, \DateInterval $interval, ?string $reason = null): Ban
    {
        return $this->banUntil($user, DateTimeUtil::nowAdd($interval), $reason);
    }

    /**
     * Ban the user for a certain period of time in minutes.
     *
     * @param User        $user The user you want to ban.
     * @param int         $days Duration of blocking in minutes.
     * @param null|string $reason Reason of ban.
     *
     * @return Ban
     */
    public function banForDays(User $user, int $days, ?string $reason = null): Ban
    {
        return $this->banUntil($user, DateTimeUtil::nowAddMinutes($days * 60 * 24), $reason);
    }

    /**
     * Blocks the user forever.
     *
     * @param User        $user The user you want to ban.
     * @param null|string $reason Reason of ban.
     *
     * @return Ban
     */
    public function banPermanently(User $user, ?string $reason = null): Ban
    {
        $ban = (new Ban($user, null))
            ->setReason($reason);
        $user->addBan($ban);
        $this->userRepository->update($user);

        return $ban;
    }

    /**
     * Deletes all active user blocks.
     *
     * @param User $user The user you want to unblock.
     *
     * @return bool Did you unlock the user?
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
