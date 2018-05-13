<?php
declare(strict_types = 1);

namespace Tests\Integrated\Services\Infrastructure\Notification\Drivers;

use App\Services\Notification\Drivers\Session;
use App\Services\Notification\Notifications\Info;
use App\Services\Notification\Notifications\Success;
use Illuminate\Session\Store;
use Tests\TestCase;

class SessionTest extends TestCase
{
    public function testAll()
    {
        $driver = $this->app->make(Session::class);
        $driver->push(new Success('lorem ipsum'));
        $driver->push(new Info('Hello, World!'));
        $session = $this->app->make(Store::class);
        $notifications = $session->get('notifications');
        self::assertNotNull($notifications);
        self::assertEquals(2, count($notifications));
        self::assertEquals('lorem ipsum', $notifications[0]['content']);
        self::assertEquals('Hello, World!', $notifications[1]['content']);

        $notifications = $driver->pull();
        self::assertEquals(2, count($notifications));
        self::assertEquals('lorem ipsum', $notifications[0]['content']);
        self::assertEquals('Hello, World!', $notifications[1]['content']);

        $notifications = $session->get('notifications');
        self::assertNull($notifications);
    }
}
