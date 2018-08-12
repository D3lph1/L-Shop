<?php
declare(strict_types = 1);

namespace App\Services\Auth\Hashing;

class BcryptHasher implements Hasher
{
    /**
     * {@inheritdoc}
     */
    public function make(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    /**
     * {@inheritdoc}
     */
    public function check(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}
