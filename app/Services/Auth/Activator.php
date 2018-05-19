<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Services\Auth\Generators\CodeGenerator;
use App\Entity\Activation;
use App\Entity\User;
use App\Repository\Activation\ActivationRepository;
use App\Services\DateTime\DateTimeUtil;
use Illuminate\Contracts\Config\Repository;

interface Activator
{
    /**
     * Creates a new activation for the passed user.
     *
     * @param User $user
     *
     * @return Activation
     */
    public function makeActivation(User $user): Activation;

    /**
     * Activates the passed user.
     *
     * @param User $user
     *
     * @return Activation
     */
    public function activate(User $user): Activation;

    /**
     * Attempts to complete activation. In the event that the passed code exists
     * and the activation with this code has not expired, the user is activated.
     *
     * @param string $code
     *
     * @return bool True - if the activation was completed, false - otherwise.
     */
    public function complete(string $code): bool;

    /**
     * Checks activation has expired.
     *
     * @param Activation $activation
     *
     * @return bool
     */
    public function isExpired(Activation $activation): bool;

    /**
     * Checks if the user is activated.
     *
     * @param User $user
     *
     * @return bool
     */
    public function isActivated(User $user): bool;

    /**
     * Gets the first complete activation of this user.
     *
     * @param User $user
     *
     * @return Activation|null
     */
    public function activation(User $user): ?Activation;
}
