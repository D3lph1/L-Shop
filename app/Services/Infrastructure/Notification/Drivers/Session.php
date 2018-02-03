<?php
declare(strict_types=1);

namespace App\Services\Infrastructure\Notification\Drivers;

use App\Services\Infrastructure\Notification\Notification;
use Illuminate\Session\Store;

class Session implements Driver
{
    /**
     * @var Store
     */
    private $session;

    private $key = 'notifications';

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function push(Notification $notification): void
    {
        $this->session->push($this->key, $notification->content());
        $this->session->save();
    }

    public function pull(): array
    {
        $notifications = (array)$this->session->get($this->key);
        $this->flush();

        return $notifications;
    }

    public function flush(): void
    {
        $this->session->remove($this->key);
    }
}
