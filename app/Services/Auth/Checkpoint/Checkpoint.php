<?php
declare(strict_types=1);

namespace App\Services\Auth\Checkpoint;

use App\Entity\User;

/**
 * Interface Checkpoint
 * Checkpoints - classes whose methods are called upon the occurrence of a certain event
 * in the life cycle of the auth system.
 * The login() and check() methods should generally throw exceptions. In this case,
 * authentication is interrupted.
 */
interface Checkpoint
{
    /**
     * Performed after authentication. Note that at this stage the user data is confirmed,
     * that is, it entered the correct login/password pair.
     *
     * @param User $user Authenticated user.
     *
     * @return bool The result of passing the checkpoint. True - successful. False - there
     * was a problem, in this case, authentication will be suspended.
     */
    public function login(User $user): bool;

    /**
     * It is executed when the user is received from the persistence session. That is, when
     * the user visits the application all subsequent times after authentication.
     *
     * @param User $user Authenticated user.
     *
     * @return bool The result of passing the checkpoint. True - successful. False - there
     * was a problem, in this case, authentication will be suspended.
     */
    public function check(User $user): bool;

    /**
     * Called in case of unsuccessful login attempt.
     */
    public function loginFail(): void;

    /**
     * Each checkpoint in the system must have a name so that it can be uniquely identified. This method returns the name of the checkpoint.
     *
     * @return string Name of checkpoint.
     */
    public function getName(): string;
}
