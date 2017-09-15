<?php
declare(strict_types = 1);

namespace App\Models\User;

interface UserInterface
{
    public function getId(): int;

    public function getUsername(): string;

    public function getEmail(): string;

    public function getPassword(): string;

    public function getBalance(): float;
}
