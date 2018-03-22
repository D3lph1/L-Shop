<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Services\Auth\Generators\CodeGenerator;
use App\Services\Auth\Hashing\Hasher;
use App\Entity\Reminder as Entity;
use App\Entity\User;
use App\Events\Auth\PasswordReminderCreated;
use App\Repository\Reminder\ReminderRepository;
use App\Repository\User\UserRepository;
use App\Services\DateTime\DateTimeUtil;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;

class Reminder
{
    /**
     * @var ReminderRepository
     */
    private $reminderRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var CodeGenerator
     */
    private $codeGenerator;

    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * @var Dispatcher
     */
    private $eventDispatcher;

    /**
     * @var Repository
     */
    private $config;

    /**
     * @var Request
     */
    private $request;

    public function __construct(
        ReminderRepository $reminderRepository,
        UserRepository $userRepository,
        CodeGenerator $codeGenerator,
        Hasher $hasher,
        Dispatcher $dispatcher,
        Repository $config,
        Request $request)
    {
        $this->reminderRepository = $reminderRepository;
        $this->userRepository = $userRepository;
        $this->codeGenerator = $codeGenerator;
        $this->hasher = $hasher;
        $this->eventDispatcher = $dispatcher;
        $this->config = $config;
        $this->request = $request;
    }

    /**
     * Creates a password reminder for the passed user.
     *
     * @param User $user
     *
     * @return Entity
     */
    public function makeReminder(User $user): Entity
    {
        $this->reminderRepository->deleteByUser($user);
        do {
            $code = $this->codeGenerator->generate(Entity::CODE_LENGTH);
        } while ($this->reminderRepository->findByCode($code));
        $entity = new Entity($user, $code);
        $this->reminderRepository->create($entity);
        $this->eventDispatcher->dispatch(new PasswordReminderCreated($entity, $this->request->ip()));

        return $entity;
    }

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
    public function complete(string $code, string $newPassword): bool
    {
        $entity = $this->reminderRepository->findByCode($code);
        if ($entity === null || $this->isExpired($entity)) {
            return false;
        }
        $user = $entity->getUser()->setPassword($this->hasher->make($newPassword));
        $this->userRepository->update($user);
        $this->reminderRepository->remove($entity);

        return true;
    }

    /**
     * Checks reminder has expired.
     *
     * @param Entity $reminder
     *
     * @return bool
     */
    public function isExpired(Entity $reminder): bool
    {
        return (new \DateTimeImmutable())
                ->diff(DateTimeUtil::addMinutes($reminder->getCreatedAt(), $this->config->get('auth.reminder.lifetime')))
                ->invert !== 0;
    }
}
