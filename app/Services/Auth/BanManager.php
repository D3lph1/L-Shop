<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Entity\Ban;
use App\Entity\User;

interface BanManager
{
    /**
     * Checks whether the passed ban is expired.
     *
     * @param Ban $ban Ban entity you want to check.
     *
     * @return bool
     */
    public function isExpired(Ban $ban): bool;

    /**
     * Checks whether the passed ban is permanent.
     *
     * @param Ban $ban Ban entity you want to check.
     *
     * @return bool
     */
    public function isPermanent(Ban $ban): bool;

    /**
     * Checks whether the passed user is banned forever.
     *
     * @param User $user User you want to check.
     *
     * @return bool
     */
    public function isPermanently(User $user): bool;

    /**
     * Returns all non-expired user bans.
     *
     * @param User $user The user whose bans you want to receive.
     *
     * @return Ban[]
     */
    public function notExpired(User $user): array;

    /**
     * Checks if the user is banned.
     *
     * @param User $user User you want to check.
     *
     * @return bool
     */
    public function isBanned(User $user): bool;

    /**
     * Ban the user before the specified DateTime.
     *
     * @param User               $user The user you want to ban.
     * @param \DateTimeImmutable $until Datetime when the ban ends.
     * @param null|string        $reason Reason of ban.
     *
     * @return Ban
     */
    public function banUntil(User $user, \DateTimeImmutable $until, ?string $reason = null): Ban;

    /**
     * Ban the user for a certain period of time.
     *
     * @param User          $user The user you want to ban.
     * @param \DateInterval $interval Duration of blocking.
     * @param null|string   $reason Reason of ban.
     *
     * @return Ban
     */
    public function banFor(User $user, \DateInterval $interval, ?string $reason = null): Ban;

    /**
     * Ban the user for a certain period of time in minutes.
     *
     * @param User        $user The user you want to ban.
     * @param int         $days Duration of blocking in minutes.
     * @param null|string $reason Reason of ban.
     *
     * @return Ban
     */
    public function banForDays(User $user, int $days, ?string $reason = null): Ban;

    /**
     * Blocks the user forever.
     *
     * @param User        $user The user you want to ban.
     * @param null|string $reason Reason of ban.
     *
     * @return Ban
     */
    public function banPermanently(User $user, ?string $reason = null): Ban;

    /**
     * Deletes all active user blocks.
     *
     * @param User $user The user you want to unblock.
     *
     * @return bool Did you unlock the user?
     */
    public function pardon(User $user): bool;
}
