<?php
declare(strict_types = 1);

namespace Tests\Integrated\Services\Auth;

use App\Entity\Persistence;
use App\Entity\User;
use App\Repository\Persistence\PersistenceRepository;
use App\Repository\User\UserRepository;
use App\Services\Auth\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use AuthTrait;

    public function testRegister(): void
    {
        $this->transaction();
        $this->registerPool([]);
        $auth = $this->app->make(Auth::class);
        $auth->register(new User('D3lph1', 'd3lph1.contact@gmail.com', '123456'));
        $r = $this->app->make(UserRepository::class);
        $user = $r->findByUsername('D3lph1');
        self::assertNotNull($user);
        self::assertEquals('D3lph1', $user->getUsername());
        $this->rollback();
    }

    public function testNonRememberAuthenticate(): void
    {
        $this->transaction();
        $this->registerPool([]);
        $auth = $this->app->make(Auth::class);
        $auth->register(new User('D3lph1', 'd3lph1.contact@gmail.com', '123456'));
        self::assertTrue($auth->authenticate('D3lph1', '123456', false));
        self::assertTrue($auth->check());
        $user = $auth->getUser();
        self::assertNotNull($user);
        self::assertEquals('D3lph1', $user->getUsername());
        self::assertEquals('d3lph1.contact@gmail.com', $user->getEmail());

        $r = $this->app->make(PersistenceRepository::class);
        $persistences = $r->findByUser($user);
        self::assertEquals(0, count($persistences));

        $this->rollback();
    }

    public function testRememberAuthenticate(): void
    {
        $this->transaction();
        $this->registerPool([]);
        $auth = $this->app->make(Auth::class);
        $auth->register(new User('D3lph1', 'd3lph1.contact@gmail.com', '123456'));
        self::assertTrue($auth->authenticate('D3lph1', '123456', true));
        self::assertTrue($auth->check());
        $user = $auth->getUser();
        self::assertNotNull($user);
        self::assertEquals('D3lph1', $user->getUsername());
        self::assertEquals('d3lph1.contact@gmail.com', $user->getEmail());

        $r = $this->app->make(PersistenceRepository::class);
        $persistences = $r->findByUser($user);
        self::assertEquals(1, count($persistences));
        /** @var Persistence $persistence */
        $persistence = $persistences[0];
        self::assertNotNull($persistence);

        $this->rollback();
    }

    public function testLogoutNonRemember(): void
    {
        $this->transaction();
        $this->registerPool([]);
        $auth = $this->app->make(Auth::class);
        $auth->register(new User('D3lph1', 'd3lph1.contact@gmail.com', '123456'));
        self::assertTrue($auth->authenticate('D3lph1', '123456', false));
        self::assertTrue($auth->check());
        $user = $auth->getUser();
        self::assertNotNull($user);

        $r = $this->app->make(PersistenceRepository::class);
        $persistences = $r->findByUser($user);
        self::assertEquals(0, count($persistences));

        $auth->logout();
        self::assertFalse($auth->check());

        $this->rollback();
    }
}
