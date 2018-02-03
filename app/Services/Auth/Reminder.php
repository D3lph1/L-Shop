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
     * @var Request
     */
    private $request;

    public function __construct(
        ReminderRepository $reminderRepository,
        UserRepository $userRepository,
        CodeGenerator $codeGenerator,
        Hasher $hasher,
        Dispatcher $dispatcher,
        Request $request)
    {
        $this->reminderRepository = $reminderRepository;
        $this->userRepository = $userRepository;
        $this->codeGenerator = $codeGenerator;
        $this->hasher = $hasher;
        $this->eventDispatcher = $dispatcher;
        $this->request = $request;
    }

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

    public function complete(string $code, string $newPassword): bool
    {
        $entity = $this->reminderRepository->findByCode($code);
        if ($entity === null || $entity->isExpired()) {
            return false;
        }
        $user = $entity->getUser()->setPassword($this->hasher->make($newPassword));
        $this->userRepository->update($user);
        $this->reminderRepository->remove($entity);

        return true;
    }
}
