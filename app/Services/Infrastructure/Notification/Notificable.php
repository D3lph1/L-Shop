<?php
declare(strict_types = 1);

namespace App\Services\Infrastructure\Notification;

interface Notificable
{
    /**
     * @return Notification[]
     */
    public function notifications(): array;
}
