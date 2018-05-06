<?php
declare(strict_types = 1);

namespace App\Services\Infrastructure\Response;

use App\Exceptions\InvalidArgumentTypeException;
use App\Services\Infrastructure\Notification\Notification;

/**
 * Class JsonResponse
 * Used by the application to represent the data that is waiting for the frontend
 * from the backend. It should be returned from the controllers or used as the
 * object of the response of this class. As usual response statuses, you
 * should use predefined constants from the {@see \App\Services\Infrastructure\Response\Status}
 * class.
 * <p>For example:</p>
 * <code>
 * class ExampleController extends Controller
 * {
 *     public function render(): JsonResponse
 *     {
 *         return new JsonResponse(Status::SUCCESS, '');
 *     }
 * }
 * </code>
 */
class JsonResponse implements \JsonSerializable
{
    /**
     * The text status of the response. Used on the frontend for an accurate definition of further actions.
     *
     * @var string
     */
    private $status;

    /**
     * Simple http status.
     *
     * @var int
     */
    private $httpStatus = 200;

    /**
     * The data to be added to the response.
     *
     * @var array|JsonRespondent
     */
    private $data;

    /**
     * @var Notification[]
     */
    private $notifications = [];

    /**
     * The user will be redirected along this route (redirecting to js) before processing
     * it in the js handler.
     *
     * @var string
     */
    private $earlyRedirect;

    /**
     * Params for early redirect route.
     *
     * @var array
     */
    private $earlyRedirectParams = [];

    /**
     * JsonResponse constructor.
     *
     * @param string $status The text status of the response. Used on the frontend for
     *                       an accurate definition of further actions.
     * @param array  $data   The data to be added to the response.
     */
    public function __construct(string $status, $data = [])
    {
        if (!is_array($data) && !($data instanceof JsonRespondent)) {
            throw new InvalidArgumentTypeException('$data', ['array', JsonRespondent::class], $data);
        }

        $this->status = $status;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param int $httpStatus
     *
     * @return JsonResponse
     */
    public function setHttpStatus(int $httpStatus): JsonResponse
    {
        $this->httpStatus = $httpStatus;

        return $this;
    }

    /**
     * @return array|JsonRespondent
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Addition notification to the response. This notification will be displayed to the user.
     *
     * @param Notification $notification
     *
     * @return JsonResponse
     */
    public function addNotification(Notification $notification): JsonResponse
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * @return int
     */
    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    /**
     * Sets the route for an early redirect. The user will be redirected along this route
     * (redirecting to js) before processing it in the js handler.
     *
     * @param string $to
     * @param array  $params
     *
     * @return JsonResponse
     */
    public function setEarlyRedirect(string $to, array $params = []): JsonResponse
    {
        $this->earlyRedirect = $to;
        $this->earlyRedirectParams = $params;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
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
