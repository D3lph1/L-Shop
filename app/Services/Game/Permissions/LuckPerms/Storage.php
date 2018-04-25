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
use Doctrine\Common\Collections\ArrayCollection;

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
            $groupPermissions = new ArrayCollection();
            /** @var GroupPermission $permission */
            foreach ($playerFromStorage->getPrimaryGroup()->getPermissions() as $permission) {
                $groupPermissions->add($this->fillPermission($permission));
            }
            $group = (new Group($playerFromStorage->getPrimaryGroup()->getName()))
                ->setPermissions($groupPermissions);


            $playerPermissions = new ArrayCollection();
            /** @var PlayerPermission $permission */
            foreach ($playerFromStorage->getPermissions() as $permission) {
                $playerPermissions->add($this->fillPermission($permission));
            }

            $player = (new Player($user, $group))->setPermissions($playerPermissions);

            return $player;
        }

        return null;
    }

    public function retrieveGroup(string $name): ?Group
    {
        $groupFromStorage = $this->groupRepository->findByName($name);
        if ($groupFromStorage !== null) {
            $groupPermissions = new ArrayCollection();
            /** @var GroupPermission $permission */
            foreach ($groupFromStorage->getPermissions() as $permission) {
                $groupPermissions->add($this->fillPermission($permission));
            }

            return (new Group($groupFromStorage->getName()))
                ->setPermissions($groupPermissions);
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
            ->setExpiredAt($from->getExpiredAt())
            ->setContexts($from->getContext());

        return $newPermission;
    }
}
