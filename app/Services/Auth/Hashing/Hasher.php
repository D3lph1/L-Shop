<?php
declare(strict_types = 1);

namespace App\Services\Auth\Hashing;

/**
 * Interface Hasher
 * Hasher is used to hash and validate user passwords.
 */
interface Hasher
{
    /**
     * Creates and returns a hash of the passed password.
     *
     * @param string $plainPassword
     *
     * @return string
     */
    public function make(string $plainPassword): string;

    /**
     * Checks a plain password hash with an existing hash.
     *
     * @param string $plainPassword
     * @param string $hashedPassword
     *
     * @return bool The result of the comparison. True - equivalents.
     */
    public function check(string $plainPassword, string $hashedPassword): bool;
}
