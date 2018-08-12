<?php
declare(strict_types = 1);

namespace Tests\Integrated\Services\Auth;

use App\Entity\User;
use App\Services\Auth\Auth;
use App\Services\Auth\BanManager;
use App\Services\Auth\Checkpoint\BanCheckpoint;
use App\Services\Auth\Exceptions\BannedException;
use Tests\TestCase;

class BanManagerTest extends TestCase
{
    use AuthTrait;

    public function testBanUntil(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(BanCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $user = $auth->register(new User('user', 'user@example.ru', '123456'));
        $bm = $this->app->make(BanManager::class);

        $bm->banUntil($user, new \DateTimeImmutable('+1 day'), 'Test ban');

        $f = false;
        try {
            $auth->authenticate('user', '123456');
        } catch (BannedException $e) {
            $f = true;
            $bans = $e->getBans();
            self::assertEquals('Test ban', array_pop($bans)->getReason());
        }

        self::assertTrue($f);
        $this->rollback();
    }

    public function testBanUntilExpired(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(BanCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $user = $auth->register(new User('user', 'user@example.ru', '123456'));
        $bm = $this->app->make(BanManager::class);

        $bm->banUntil($user, new \DateTimeImmutable('-1 day'), 'Test ban');
        self::assertTrue($auth->authenticate('user', '123456'));
        $this->rollback();
    }

    public function testBanForDays(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(BanCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $user = $auth->register(new User('user', 'user@example.ru', '123456'));
        $bm = $this->app->make(BanManager::class);

        $bm->banForDays($user, 3);

        $f = false;
        try {
            $auth->authenticate('user', '123456');
        } catch (BannedException $e) {
            $f = true;
        }

        self::assertTrue($f);
        $this->rollback();
    }

    public function testBanFor(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(BanCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $user = $auth->register(new User('user', 'user@example.ru', '123456'));
        $bm = $this->app->make(BanManager::class);

        $bm->banFor($user, \DateInterval::createFromDateString('1 year'));

        $f = false;
        try {
            $auth->authenticate('user', '123456');
        } catch (BannedException $e) {
            $f = true;
        }

        self::assertTrue($f);
        $this->rollback();
    }

    public function testBanPermanently(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(BanCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $user = $auth->register(new User('user', 'user@example.ru', '123456'));
        $bm = $this->app->make(BanManager::class);

        $bm->banPermanently($user);

        $f = false;
        try {
            $auth->authenticate('user', '123456');
        } catch (BannedException $e) {
            $f = true;
        }

        self::assertTrue($f);
        $this->rollback();
    }

    public function testIsExpired(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(BanCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $user = $auth->register(new User('user', 'user@example.ru', '123456'));
        $bm = $this->app->make(BanManager::class);

        $ban1 = $bm->banUntil($user, new \DateTimeImmutable('-1 day'));
        $ban2 = $bm->banUntil($user, new \DateTimeImmutable('+1 day'), 'Test ban');
        $ban3 = $bm->banForDays($user, 10, 'Test ban');
        $ban4 = $bm->banPermanently($user, 'Test ban');
        self::assertTrue($bm->isExpired($ban1));
        self::assertFalse($bm->isExpired($ban2));
        self::assertFalse($bm->isExpired($ban3));
        self::assertFalse($bm->isExpired($ban4));

        $this->rollback();
    }

    public function testNotExpired(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(BanCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $user = $auth->register(new User('user', 'user@example.ru', '123456'));
        $bm = $this->app->make(BanManager::class);

        $bans = [$bm->banUntil($user, new \DateTimeImmutable('-1 day'))];
        $bans[] = $bm->banUntil($user, new \DateTimeImmutable('+1 day'), 'Test ban'); // 1
        $bans[] = $bm->banForDays($user, 10, 'Test ban');  // 2
        $bans[] = $bm->banPermanently($user, 'Test ban'); // 3
        self::assertEquals(3, count($bm->notExpired($user)));

        $this->rollback();
    }

    public function testIsPermanent(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(BanCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $user = $auth->register(new User('user', 'user@example.ru', '123456'));
        $bm = $this->app->make(BanManager::class);

        $ban1 = $bm->banForDays($user, 10, 'Test ban 1');
        $ban2 = $bm->banPermanently($user, 'Test ban 2');
        self::assertFalse($bm->isPermanent($ban1));
        self::assertTrue($bm->isPermanent($ban2));

        $this->rollback();
    }

    public function testIsPermanently(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(BanCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $user1 = $auth->register(new User('user', 'user@example.ru', '123456'));
        $bm = $this->app->make(BanManager::class);

        $bm->banPermanently($user1);
        self::assertTrue($bm->isPermanently($user1));
        $user2 = $auth->register(new User('example', 'example@example.ru', '123456'));
        $bm->banForDays($user2, 1);
        self::assertFalse($bm->isPermanently($user2));

        $this->rollback();
    }

    public function testIsBanned(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(BanCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $user1 = $auth->register(new User('user1', 'user1@example.ru', '123456'));
        $bm = $this->app->make(BanManager::class);

        $bm->banForDays($user1, 2);
        self::assertTrue($bm->isBanned($user1));

        $user2 = $auth->register(new User('user2', 'user2@example.ru', '123456'));
        self::assertFalse($bm->isBanned($user2));

        $user3 = $auth->register(new User('user3', 'user3@example.ru', '123456'));
        $bm->banUntil($user3, new \DateTimeImmutable('-1 day'));
        self::assertFalse($bm->isBanned($user3));

        $this->rollback();
    }

    public function testPardon(): void
    {
        $this->transaction();
        $this->registerPool([$this->app->make(BanCheckpoint::class)]);
        $auth = $this->app->make(Auth::class);
        $user = $auth->register(new User('user', 'user@example.ru', '123456'));
        $bm = $this->app->make(BanManager::class);

        $bm->banForDays($user, 3);

        $f = false;
        try {
            $auth->authenticate('user', '123456');
        } catch (BannedException $e) {
            $f = true;
        }

        self::assertTrue($f);

        $bm->pardon($user);

        self::assertTrue($auth->authenticate('user', '123456'));

        $this->rollback();
    }
}
