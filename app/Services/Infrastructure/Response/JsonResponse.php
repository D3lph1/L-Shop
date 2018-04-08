<?php
declare(strict_types = 1);

namespace App\Services\Infrastructure\Response;

use App\Exceptions\InvalidArgumentTypeException;
use App\Services\Infrastructure\Notification\Notification;

class JsonResponse implements \JsonSerializable
{
    /**
     * @var string
     */
    private $status;

    /**
     * @var array|JsonRespondent
     */
    private $data;

    /**
     * @var Notification[]
     */
    private $notifications = [];

    /**
     * @var string
     */
    private $earlyRedirect;

    /**
     * @var array
     */
    private $earlyRedirectParams = [];

    public function __construct(string $status, $data = [])
    {
        if (!is_array($data) && !($data instanceof JsonRespondent)) {
            throw new InvalidArgumentTypeException('$data', ['array', JsonRespondent::class], $data);
        }

        $this->status = $status;
        $this->data = $data;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return array|object
     */
    public function getData()
    {
        return $this->data;
    }

    public function addNotification(Notification $notification): JsonResponse
    {
        $this->notifications[] = $notification;

        return $this;
    }

    public function setEarlyRedirect(string $to, array $params = []): JsonResponse
    {
        $this->earlyRedirect = $to;
        $this->earlyRedirectParams = $params;

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

        if (is_array($this->data)) {
            $data = $this->data;
        } else {
            $data = $this->data->response();
        }

        $result = array_merge([
            'status' => $this->status,
        ], $data);

        $result = array_merge($result, [
            'notifications' => $notifications
        ]);
        if ($this->earlyRedirect !== null) {
            $result = array_merge($result, [
                'early_redirect' => $this->earlyRedirect,
                'early_redirect_params' => $this->earlyRedirectParams
            ]);
        }

        return $result;
    }
}
