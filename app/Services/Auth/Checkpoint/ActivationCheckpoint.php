<?php
declare(strict_types = 1);

namespace App\Services\Auth\Checkpoint;

use App\Entity\Activation;
use App\Entity\User;
use App\Repository\Activation\ActivationRepository;
use App\Services\Auth\Exceptions\NotActivatedException;

/**
 * Class ActivationCheckpoint
 * This checkpoint is used to deny access to those users whose account is not activated.
 */
class ActivationCheckpoint implements Checkpoint
{
    public const NAME = 'activation';

    /**
     * @var ActivationRepository
     */
    private $activationRepository;

    public function __construct(ActivationRepository $activationRepository)
    {
        $this->activationRepository = $activationRepository;
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function check(User $user): bool
    {
        return $this->login($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loginFail(?User $user = null): void
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
