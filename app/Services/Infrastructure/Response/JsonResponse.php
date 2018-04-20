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
     * @var int
     */
    private $httpStatus = 200;

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

    public function setHttpStatus(int $httpStatus): JsonResponse
    {
        $this->httpStatus = $httpStatus;

        return $this;
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

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
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
            'httpStatus' => $this->httpStatus
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
