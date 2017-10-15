<?php
declare(strict_types = 1);

namespace App\Models\Reminder;

use Carbon\Carbon;

interface ReminderInterface
{
    public function getId(): int;

    public function setUserId(int $userId): ReminderInterface;

    public function getUserId(): int;

    public function setCode(string $code): ReminderInterface;

    public function getCode(): string;

    public function setCompleted(bool $isCompleted): ReminderInterface;

    public function isCompleted(): bool;

    public function getCompletedAt(): ?Carbon;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
