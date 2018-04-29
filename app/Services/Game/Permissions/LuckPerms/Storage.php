<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms;

use App\Entity\User;
use App\Repository\Server\ServerRepository;
use App\Services\Game\Permissions\Group;
use App\Services\Game\Permissions\LuckPerms\Entity\GroupPermission;
use App\Services\Game\Permissions\LuckPerms\Entity\PlayerPermission;
use App\Services\Game\Permissions\LuckPerms\Repository\Group\GroupRepository;
use App\Services\Game\Permissions\LuckPerms\Repository\Player\PlayerRepository;
use App\Services\Game\Permissions\Permission;
use App\Services\Game\Permissions\Player;
use App\Services\Game\Permissions\Storage as StorageInterface;

class Storage implements StorageInterface
{
    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var ServerRepository
     */
    private $serverRepository;

    public function __construct(
        PlayerRepository $playerRepository,
        GroupRepository $groupRepository,
        ServerRepository $serverRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->groupRepository = $groupRepository;
        $this->serverRepository = $serverRepository;
    }

    public function retrievePlayer(User $user): ?Player
    {
        $playerFromStorage = $this->playerRepository->findByUsername($user->getUsername());
        if ($playerFromStorage !== null) {
            $group = $this->retrieveGroup($playerFromStorage->getPrimaryGroup()->getName());

            $player = new Player($user, $group);
            /** @var PlayerPermission $permission */
            foreach ($playerFromStorage->getPermissions() as $permission) {
                $newPermission = $this->fillPermission($permission);
                if ($this->expired($newPermission->getExpireAt())) {
                    // Remove permission if it has expired.
                    $playerFromStorage->getPermissions()->removeElement($permission);
                } else {
                    $player->getPermissions()->add($newPermission);

                    $parentGroupName = $this->getGroupNameByPermission($newPermission);
                    if ($parentGroupName !== null) {
                        $parentGroup = $this->retrieveGroup($parentGroupName);
                        if ($parentGroup !== null) {
                            $player->getGroups()->add($parentGroup);
                        }
                    }
                }
            }
            // Updates the player. If he has removed the permissions, the changes will
            // take effect in the repository.
            $this->playerRepository->update($playerFromStorage);

            return $player;
        }

        return null;
    }

    public function retrieveGroup(string $name): ?Group
    {
        $groupFromStorage = $this->groupRepository->findByName($name);
        if ($groupFromStorage !== null) {
            $group = new Group($groupFromStorage->getName());
            /** @var GroupPermission $permission */
            foreach ($groupFromStorage->getPermissions() as $permission) {
                $newPermission = $this->fillPermission($permission);
                if ($this->expired($newPermission->getExpireAt())) {
                    // Remove permission if it has expired.
                    $groupFromStorage->getPermissions()->removeElement($permission);
                } else {
                    $group->getPermissions()->add($newPermission);

                    $parentGroupName = $this->getGroupNameByPermission($newPermission);
                    if ($parentGroupName !== null) {
                        $parentGroup = $this->retrieveGroup($parentGroupName);
                        $group->setExpireAt($newPermission->getExpireAt());
                        $group->getParents()->add($parentGroup);
                        $parentGroup->getChilds()->add($group);
                    }
                }
            }
            // Updates the group. If he has removed the permissions, the changes will
            // take effect in the repository.
            $this->groupRepository->update($groupFromStorage);

            return $group;
        }

        return null;
    }

    /**
     * @param GroupPermission|PlayerPermission $from
     *
     * @return Permission
     */
    private function fillPermission($from): Permission
    {
        $newPermission = new Permission($from->getPermission());
        $server = null;
        if ($from->getServer() !== 'global') {
            $server = $this->serverRepository->find((int)$from->getServer());
        }

        $newPermission->setAllowed($from->getValue())
            ->setServer($server)
            ->setWorld($from->getWorld())
            ->setExpireAt(
                $from->getExpireAt() !== 0
                    ? \DateTimeImmutable::createFromFormat('U', (string)$from->getExpireAt())
                    : null
            )
            ->setContexts($from->getContext());

        return $newPermission;
    }

    private function getGroupNameByPermission(Permission $permission): ?string
    {
        if (mb_strpos($permission->getName(), 'group') === 0) {
            return mb_substr($permission->getName(), mb_strlen('group.'));
        }

        return null;
    }

    private function expired(?\DateTimeImmutable $expireAt): bool
    {
        if ($expireAt === null) {
            return false;
        }

        return (new \DateTimeImmutable())
                ->diff($expireAt)
                ->invert !== 0;
    }
}
