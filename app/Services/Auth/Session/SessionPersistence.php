<?php
declare(strict_types=1);

namespace App\Services\Auth\Session;

use App\Services\Auth\Checkpoint\Pool;
use App\Services\Auth\Generators\CodeGenerator;
use App\Services\Auth\Session\Driver\Driver;
use App\Entity\Persistence;
use App\Entity\User;
use App\Repository\Persistence\PersistenceRepository;
use App\Repository\User\UserRepository;

class SessionPersistence
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PersistenceRepository
     */
    private $persistenceRepository;

    /**
     * @var CodeGenerator
     */
    private $codeGenerator;

    /**
     * @var Driver
     */
    private $sessionDriver;

    /**
     * @var Pool
     */
    private $checkpointsPool;

    public function __construct(
        UserRepository $userRepository,
        PersistenceRepository $persistenceRepository,
        CodeGenerator $keyGenerator,
        Driver $sessionDriver,
        Pool $checkpointsPool)
    {
        $this->userRepository = $userRepository;
        $this->persistenceRepository = $persistenceRepository;
        $this->codeGenerator = $keyGenerator;
        $this->sessionDriver = $sessionDriver;
        $this->checkpointsPool = $checkpointsPool;
    }

    public function createFromUser(User $user, bool $remember): Session
    {
        if (!$remember) {
            return new Session($user);
        }

        do {
            $code = $this->codeGenerator->generate(Persistence::CODE_LENGTH);
        } while($this->persistenceRepository->findByCode($code));

        $persistence = new Persistence($code, $user);
        $this->persistenceRepository->create($persistence);
        $this->sessionDriver->set($persistence->getCode());

        return new Session($user);
    }

    public function createFromPersistenceStorage(): Session
    {
        $code = $this->sessionDriver->get();
        if (empty($code)) {
            return $this->createEmpty();
        }
        
        $persistence = $this->persistenceRepository->findByCode($code);
        if ($persistence === null) {
            return $this->createEmpty();
        }

        // If code lifetime has expired.
        if ($persistence->isExpired()) {
            return $this->createEmpty();
        }
        $user = $this->userRepository->findById($persistence->getUser()->getId());

        if (!$this->checkpointsPool->passCheck($user)) {
            return $this->createEmpty();
        }

        return new Session($user);
    }

    public function destroy(User $user, bool $destroyAll): void
    {
        if ($destroyAll) {
            $this->persistenceRepository->deleteByUser($user);
        } else {
            $code = $this->sessionDriver->get();
            if (!empty($code)) {
                $this->persistenceRepository->deleteByCode($code);
            }
        }

        $this->sessionDriver->forget();
    }

    public function createEmpty(): Session
    {
        return new Session(null);
    }
}
