<?php
declare(strict_types = 1);

namespace App\Services\Auth\Checkpoint;

use App\Entity\User;

interface Checkpoint
{
    public function login(User $user): bool;

    public function check(User $user): bool;

    public function loginFail(): void;

    public function getName(): string;
}
