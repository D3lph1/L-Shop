<?php
declare(strict_types = 1);

namespace Tests\Integrated\Services\Game\Permissions\LuckPerms;

use App\Entity\User;
use App\Services\Auth\Auth;
use App\Services\Game\Permissions\LuckPerms\Entity\Group;
use App\Services\Game\Permissions\LuckPerms\Entity\GroupPermission;
use App\Services\Game\Permissions\LuckPerms\Entity\Player;
use App\Services\Game\Permissions\LuckPerms\Entity\PlayerPermission;
use App\Services\Game\Permissions\LuckPerms\Repository\Group\GroupRepository;
use App\Services\Game\Permissions\LuckPerms\Repository\Player\PlayerRepository;
use App\Services\Game\Permissions\LuckPerms\Storage;
use Tests\TestCase;

class StorageTest extends TestCase
{
    public function testRetrievePlayer(): void
    {
        $this->transaction();
        $user = new User('admin1', 'admin1@example.com', 'admin');
        $this->app->make(Auth::class)->register($user, true);

        $storage = $this->app->make(Storage::class);
        $groupDefault = new Group('default');
        $groupDefault->getPermissions()->add(new GroupPermission('ingroup.one', $groupDefault));
        $groupDefault->getPermissions()->add(new GroupPermission('ingroup.two', $groupDefault));
        $this->app->make(GroupRepository::class)->create($groupDefault);
        $adminPlayer = new Player($user, $groupDefault);
        $adminPlayer->getPermissions()->add(new PlayerPermission('inplayer.one', $adminPlayer));
        $this->app->make(PlayerRepository::class)->create($adminPlayer);
        $player = $storage->retrievePlayerByUser($user);
        self::assertNotNull($player);
        self::assertEquals('default', $player->getPrimaryGroup()->getName());
        self::assertEquals(2, $player->getPrimaryGroup()->getPermissions()->count());
        self::assertEquals('ingroup.one', $player->getPrimaryGroup()->getPermissions()->first()->getName());
        self::assertEquals('ingroup.two', $player->getPrimaryGroup()->getPermissions()->next()->getName());
        self::assertEquals(1, $player->getPermissions()->count());
        self::assertEquals('inplayer.one', $player->getPermissions()->first()->getName());

        $this->rollback();
    }

    public function testRetrieveGroup(): void
    {
        $this->transaction();
        $groupDefault = new Group('default');
        $groupDefault->getPermissions()->add(new GroupPermission('ingroup.one', $groupDefault));
        $groupDefault->getPermissions()->add(new GroupPermission('ingroup.two', $groupDefault));
        $this->app->make(GroupRepository::class)->create($groupDefault);

        $groupAdmins = new Group('admins');
        $this->app->make(GroupRepository::class)->create($groupAdmins);

        $storage = $this->app->make(Storage::class);
        $group = $storage->retrieveGroup('default');

        self::assertEquals('default', $group->getName());
        self::assertEquals(2, $group->getPermissions()->count());
        self::assertEquals('ingroup.one', $group->getPermissions()->first()->getName());
        self::assertEquals('ingroup.two', $group->getPermissions()->next()->getName());

        $group = $storage->retrieveGroup('admins');
        self::assertEquals(0, $group->getPermissions()->count());

        $this->rollback();
    }
}
