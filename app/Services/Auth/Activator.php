<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Services\Auth\Generators\CodeGenerator;
use App\Entity\Activation;
use App\Entity\User;
use App\Repository\Activation\ActivationRepository;

class Activator
{
    /**
     * @var ActivationRepository
     */
    private $activationRepository;

    /**
     * @var CodeGenerator
     */
    private $codeGenerator;

    public function __construct(ActivationRepository $activationRepository, CodeGenerator $codeGenerator)
    {
        $this->activationRepository = $activationRepository;
        $this->codeGenerator = $codeGenerator;
    }

    public function makeActivation(User $user): Activation
    {
        $this->activationRepository->deleteByUser($user);
        do {
            $code = $this->codeGenerator->generate(Activation::CODE_LENGTH);
        } while ($this->activationRepository->findByCode($code));
        $activation = new Activation($user, $code);
        $this->activationRepository->create($activation);

        return $activation;
    }

    public function activate(User $user): Activation
    {
        do {
            $code = $this->codeGenerator->generate(Activation::CODE_LENGTH);
        } while ($this->activationRepository->findByCode($code));
        $activation = (new Activation($user, $code))
            ->complete();
        $this->activationRepository->create($activation);

        return $activation;
    }

    public function complete(string $code): bool
    {
        $activation = $this->activationRepository->findByCode($code);
        if ($activation === null || $activation->isExpired() || $activation->isCompleted()) {
            return false;
        }
        $this->activationRepository->update($activation->complete());

        return true;
    }

    public function isActivated(User $user): bool
    {
        $activations = $user->getActivations();
        /** @var Activation $activation */
        foreach ($activations as $activation) {
            if ($activation->isCompleted()) {
                return true;
            }
        }

        return false;
    }
}
