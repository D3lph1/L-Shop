<?php
declare(strict_types = 1);

namespace Tests\Integrated\Services\Game\Permissions\LuckPerms;

use App\Entity\User;
use App\Services\Auth\Auth;
use App\Services\DateTime\DateTimeUtil;
use App\Services\Game\Permissions\Funnel;
use App\Services\Game\Permissions\LuckPerms\Entity\Group;
use App\Services\Game\Permissions\LuckPerms\Entity\GroupPermission;
use App\Services\Game\Permissions\LuckPerms\Entity\Player;
use App\Services\Game\Permissions\LuckPerms\Entity\PlayerPermission;
use App\Services\Game\Permissions\LuckPerms\Repository\Group\GroupRepository;
use App\Services\Game\Permissions\LuckPerms\Repository\Player\PlayerRepository;
use App\Services\Game\Permissions\LuckPerms\Repository\PlayerPermission\PlayerPermissionRepository;
use App\Services\Game\Permissions\LuckPerms\Storage;
use App\Services\Game\Permissions\Permission;
use App\Services\Game\Permissions\Predicates\PermissionPredicate;
use App\Services\Game\Permissions\Predicates\Regex;
use Tests\TestCase;

class FunnelTest extends TestCase
{
    public function testFilterPlayerPermissions(): void
    {
        $this->transaction();

        // Initialization

        $user = new User('admin1', 'admin1@example.com', 'admin');
        $this->app->make(Auth::class)->register($user, true);

        $groupDefault = new Group('default');
        $groupDefault->getPermissions()->add(new GroupPermission('default.1', $groupDefault));
        $groupDefault->getPermissions()->add(new GroupPermission('default.2', $groupDefault));

        $groupRepository = $this->app->make(GroupRepository::class);
        $groupRepository->create($groupDefault);

        $groupUsers = new Group('users');
        $groupUsers->getPermissions()->add(new GroupPermission('users.1', $groupUsers));
        $groupUsers->getPermissions()->add(
            (new GroupPermission('users.expired', $groupUsers))
                ->setExpireAt((int)DateTimeUtil::nowSubMinutes(100)->format('U'))
        );
        $groupUsers->getPermissions()->add(
            (new GroupPermission('users.not_expired', $groupUsers))
                ->setExpireAt((int)DateTimeUtil::nowAddMinutes(100)->format('U'))
        );
        $groupUsers->getPermissions()->add(new GroupPermission('group.default', $groupUsers));
        $groupRepository->create($groupUsers);

        $groupAdmins = new Group('admins');
        $groupAdmins->getPermissions()->add(
            (new GroupPermission('admins.1', $groupAdmins))
                ->setServer('3')
                ->setWorld('nether')
        );
        $groupAdmins->getPermissions()->add(new GroupPermission('admins.2', $groupAdmins));
        $groupAdmins->getPermissions()->add(new GroupPermission('group.users', $groupAdmins));
        $groupRepository->create($groupAdmins);

        $adminPlayer = new Player($user, $groupDefault);
        $this->app->make(PlayerRepository::class)->create($adminPlayer);
        $adminPlayerPermission = new PlayerPermission('group.admins', $adminPlayer);
        $adminPlayer->getPermissions()->add($adminPlayerPermission);
        $this->app->make(PlayerPermissionRepository::class)->create($adminPlayerPermission);

        $storage = $this->app->make(Storage::class);
        $player = $storage->retrievePlayerByUser($user);
        $funnel = $this->app->make(Funnel::class);

        // End initialization.

        // 1

        $predicate1 = (new PermissionPredicate())
            ->setPermission(new Regex('/[a-z]+\.1/ui'));
        $result1 = $funnel->filterPlayerPermissions($player, $predicate1);

        self::assertEquals(3, $result1->count());
        self::assertTrue($result1->exists($this->permissionEquals('default.1')));
        self::assertTrue($result1->exists($this->permissionEquals('users.1')));
        self::assertTrue($result1->exists($this->permissionEquals('admins.1')));

        // 2

        $predicate2 = (new PermissionPredicate())
            ->setPermission(new Regex('/users\..+/ui'));
        $result2 = $funnel->filterPlayerPermissions($player, $predicate2);

        self::assertEquals(2, $result2->count());
        self::assertTrue($result2->exists($this->permissionEquals('users.1')));
        self::assertTrue($result2->exists($this->permissionEquals('users.not_expired')));

        // 3

        $predicate3 = (new PermissionPredicate())
            ->setAnyServer(false)
            ->setServer('3');
        $result3 = $funnel->filterPlayerPermissions($player, $predicate3);

        self::assertEquals(1, $result3->count());
        self::assertTrue($result3->exists($this->permissionEquals('admins.1')));

        // 4

        $predicate4 = (new PermissionPredicate())
            ->setAnyWorld(false)
            ->setWorld('nether');
        $result4 = $funnel->filterPlayerPermissions($player, $predicate4);

        self::assertEquals(1, $result4->count());
        self::assertTrue($result4->exists($this->permissionEquals('admins.1')));

        // 5

        $predicate5 = (new PermissionPredicate())
            ->setAnyContexts(false)
            ->setContexts('some string...');
        $result5 = $funnel->filterPlayerPermissions($player, $predicate5);

        self::assertEquals(0, $result5->count());

        $this->rollback();
    }

    private function permissionEquals(string $permissionName): callable
    {
        return function (int $index, Permission $permission) use ($permissionName) {
            return $permission->getName() === $permissionName;
        };
    }
}
