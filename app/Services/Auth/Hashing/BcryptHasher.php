<?php
declare(strict_types = 1);

namespace App\Services\Auth\Hashing;

class BcryptHasher implements Hasher
{
    public function make(string $plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    public function check(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}
