<?php
declare(strict_types = 1);

namespace App\Services\Infrastructure\Notification\Drivers;

use App\Services\Infrastructure\Notification\Notification;

interface Driver
{
    public function push(Notification $notification): void;

    public function pull(): array;

    public function flush(): void;
}
