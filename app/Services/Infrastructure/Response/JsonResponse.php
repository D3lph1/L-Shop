<?php
declare(strict_types = 1);

namespace App\Services\Infrastructure\Response;

use App\Services\Infrastructure\Notification\Notification;
use App\Services\Infrastructure\Notification\Notificator;
use Illuminate\Support\Facades\Log;

class JsonResponse implements \JsonSerializable
{
    /**
     * @var string
     */
    private $status;

    /**
     * @var array
     */
    private $data;

    /**
     * @var Notification[]
     */
    private $notifications = [];

    public function __construct(string $status, array $data = [])
    {
        $this->status = $status;
        $this->data = $data;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function addNotification(Notification $notification): JsonResponse
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $notifications = [];
        foreach ($this->notifications as $notification) {
            array_push($notifications, $notification->content());
        }

        $result = array_merge([
            'status' => $this->status,
        ], $this->data);

        $result = array_merge($result, [
            'notifications' => $notifications
        ]);


        return $result;
    }
}
