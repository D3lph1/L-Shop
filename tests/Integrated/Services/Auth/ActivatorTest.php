<?php
declare(strict_types = 1);

namespace Tests\Integrated\Services\Auth;

use App\Services\Auth\Activator;
use App\Services\Auth\Auth;
use App\Services\Auth\Checkpoint\ActivationCheckpoint;
use App\Services\Auth\Exceptions\NotActivatedException;
use App\Entity\User;
use Tests\TestCase;

class ActivatorTest extends TestCase
{
    use AuthTrait;

    public function testFail(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(ActivationCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $auth->register(new User('D3lph1', 'd3lph1.contact@gmail.com', '123456'));

        $exception = false;
        try {
            $auth->authenticate('D3lph1', '123456', true);
        } catch (NotActivatedException $e) {
            $exception = true;
        }
        self::assertTrue($exception);

        $this->rollback();
    }

    public function testComplete(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(ActivationCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $user = new User('D3lph1', 'd3lph1.contact@gmail.com', '123456');
        $auth->register($user);

        $activator = $this->app->make(Activator::class);
        $activation = $activator->makeActivation($user);
        $code = $activation->getCode();
        self::assertTrue($activator->complete($code));
        self::assertTrue($activation->isCompleted());
        self::assertNotNull($activation->getCompletedAt());

        self::assertTrue($auth->authenticate('D3lph1', '123456', true));

        // Already completed.
        self::assertFalse($activator->complete($code));

        $this->rollback();
    }

    public function testActivate(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(ActivationCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $user = new User('D3lph1', 'd3lph1.contact@gmail.com', '123456');
        $auth->register($user);

        $activator = $this->app->make(Activator::class);
        $activator->activate($user);
        self::assertTrue($auth->authenticate('D3lph1', '123456', true));

        $this->rollback();
    }
}
