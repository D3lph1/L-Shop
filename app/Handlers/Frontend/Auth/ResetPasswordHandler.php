<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Auth;

use App\Repository\Reminder\ReminderRepository;
use App\Services\Auth\Reminder;

class ResetPasswordHandler
{
    /**
     * @var Reminder
     */
    private $reminder;

    private $repository;

    public function __construct(Reminder $reminder, ReminderRepository $repository)
    {
        $this->reminder = $reminder;
        $this->repository = $repository;
    }

    public function handle(string $code, string $newPassword): bool
    {
        return $this->reminder->complete($code, $newPassword);
    }

    public function isValidCode(string $code): bool
    {
        $entity = $this->repository->findByCode($code);

        return $entity !== null && !$entity->isExpired();
    }
}
