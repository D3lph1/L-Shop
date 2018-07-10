<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Player
 * Encapsulates the player's state by storing the user to which it belongs, permissions. groups.
 */
abstract class Player
{
    /**
     * @var Collection
     */
    private $permissions;

    /**
     * @var Group
     */
    private $primaryGroup;

    /**
     * @var Collection
     */
    private $groups;

    public function __construct(Group $primaryGroup)
    {
        $this->primaryGroup = $primaryGroup;
        $this->groups = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    public function getPrimaryGroup(): Group
    {
        return $this->primaryGroup;
    }

    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function getGroups(): Collection
    {
        return $this->groups;
    }
}
