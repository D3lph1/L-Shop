<?php
declare(strict_types = 1);

namespace App\Services\Infrastructure\Notification;

interface Notification
{
    /**
     * The data returned from this method will be used by the notification driver
     * for storage and distribution.
     *
     * @return mixed
     */
    public function content();
}
