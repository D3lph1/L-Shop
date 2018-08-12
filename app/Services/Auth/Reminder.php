<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Entity\Reminder as Entity;
use App\Entity\User;

interface Reminder
{
    /**
     * Creates a password reminder for the passed user.
     *
     * @param User $user
     *
     * @return Entity
     */
    public function makeReminder(User $user): Entity;

    /**
     * Tries to complete the reminder. If the reminder with the transmitted code
     * exists and has not expired, it completes it and changes the user's
     * password to the passed one.
     *
     * @param string $code        Reminder code.
     * @param string $newPassword Password to be set to the user.
     *
     * @return bool True - if the reminder was completed, false - otherwise.
     */
    public function complete(string $code, string $newPassword): bool;

    /**
     * Checks reminder has expired.
     *
     * @param Entity $reminder
     *
     * @return bool
     */
    public function isExpired(Entity $reminder): bool;
}
