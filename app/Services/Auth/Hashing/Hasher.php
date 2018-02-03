<?php
declare(strict_types = 1);

namespace App\Services\Auth\Hashing;

interface Hasher
{
    public function make(string $plainPassword);

    public function check(string $plainPassword, string $hashedPassword): bool;
}
