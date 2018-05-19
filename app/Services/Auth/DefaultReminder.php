<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Services\Auth\Generators\CodeGenerator;
use App\Services\Auth\Hashing\Hasher;
use App\Entity\Reminder as Entity;
use App\Entity\User;
use App\Events\Auth\PasswordReminderCreatedEvent;
use App\Repository\Reminder\ReminderRepository;
use App\Repository\User\UserRepository;
use App\Services\DateTime\DateTimeUtil;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;

class DefaultReminder implements Reminder
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
     * {@inheritdoc}
     */
    public function makeReminder(User $user): Entity
    {
        $this->reminderRepository->deleteByUser($user);
        do {
            $code = $this->codeGenerator->generate(Entity::CODE_LENGTH);
        } while ($this->reminderRepository->findByCode($code));
        $entity = new Entity($user, $code);
        $this->reminderRepository->create($entity);
        $this->eventDispatcher->dispatch(new PasswordReminderCreatedEvent($entity, $this->request->ip()));

        return $entity;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function isExpired(Entity $reminder): bool
    {
        return (new \DateTimeImmutable())
                ->diff(DateTimeUtil::addMinutes($reminder->getCreatedAt(), $this->config->get('auth.reminder.lifetime')))
                ->invert !== 0;
    }
}
