<?php
declare(strict_types = 1);

namespace App\Services\Infrastructure\Notification\Notifications;

use App\Services\Infrastructure\Notification\Notification;

class Danger implements Notification
{
    private $type = 'danger';

    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * {@inheritdoc}
     */
    public function content()
    {
        return [
            'type' => $this->type,
            'content' => $this->content
        ];
    }
}
