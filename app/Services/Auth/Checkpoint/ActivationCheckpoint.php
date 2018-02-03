<?php
declare(strict_types = 1);

namespace App\Services\Auth\Checkpoint;

use App\Services\Auth\Exceptions\NotActivatedException;
use App\Entity\Activation;
use App\Entity\User;
use App\Repository\Activation\ActivationRepository;

class ActivationCheckpoint implements Checkpoint
{
    public const NAME = 'activation';

    private $activationRepository;

    public function __construct(ActivationRepository $activationRepository)
    {
        $this->activationRepository = $activationRepository;
    }

    public function login(User $user): bool
    {
        /** @var Activation[] $activations */
        $activations = $this->activationRepository->findByUser($user);
        foreach ($activations as $activation) {
            if ($activation->isCompleted()) {
                return true;
            }
        }

        throw new NotActivatedException($user);
    }

    public function check(User $user): bool
    {
        return $this->login($user);
    }

    public function loginFail(): void
    {
        //
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
