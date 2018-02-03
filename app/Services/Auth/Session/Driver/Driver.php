<?php
declare(strict_types = 1);

namespace App\Services\Auth\Session\Driver;

interface Driver
{
    public function get(): ?string;

    public function set(string $persistenceCode): void;

    public function forget(): void;
}
