<?php
declare(strict_types = 1);

namespace App\Services\Auth\Hashing;

class Sha256Hasher implements Hasher
{
    /**
     * @inheritDoc
     */
    public function make(string $plainPassword): string
    {
        return hash('sha256', $plainPassword);
    }

    /**
     * @inheritDoc
     */
    public function check(string $plainPassword, string $hashedPassword): bool
    {
        return $this->make($plainPassword) === $hashedPassword;
    }
}
