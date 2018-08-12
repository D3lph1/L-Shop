<?php
declare(strict_types = 1);

namespace App\Repository\Reminder;

use App\Entity\Reminder;
use App\Entity\User;

interface ReminderRepository
{
    public function create(Reminder $reminder): void;

    public function deleteAll(): bool;

    public function findByCode(string $code): ?Reminder;

    public function remove(Reminder $reminder): void;

    public function deleteByUser(User $user): void;
}
