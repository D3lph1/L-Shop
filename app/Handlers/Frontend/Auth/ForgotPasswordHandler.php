<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Auth;

use App\Repository\User\UserRepository;
use App\Services\Auth\Exceptions\UserDoesNotExistException;
use App\Services\Auth\Reminder;

class ForgotPasswordHandler
{
    /**
     * @var Reminder
     */
    private $reminder;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(Reminder $reminder, UserRepository $userRepository)
    {
        $this->reminder = $reminder;
        $this->userRepository = $userRepository;
    }

    public function handle(string $email): void
    {
        $user = $this->userRepository->findByEmail($email);
        if ($user === null) {
            throw new UserDoesNotExistException($email);
        }
        $this->reminder->makeReminder($user);
    }
}
