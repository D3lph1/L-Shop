<?php
declare(strict_types = 1);

namespace App\Services\Auth\Hashing;

class WhirlpoolHasher implements Hasher
{
    /**
     * @inheritDoc
     */
    public function make(string $plainPassword): string
    {
        return hash('whirlpool', $plainPassword);
    }

    /**
     * @inheritDoc
     */
    public function check(string $plainPassword, string $hashedPassword): bool
    {
        return $this->make($plainPassword) === $hashedPassword;
    }
}
