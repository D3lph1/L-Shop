<?php
declare(strict_types = 1);

namespace App\Services\Notification;

interface Notificable
{
    /**
     * @return Notification[]
     */
    public function notifications(): array;
}
