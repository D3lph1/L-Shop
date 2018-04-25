<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions;

use App\Entity\User;
use Doctrine\Common\Collections\Collection;

/**
 * Class Player
 * Encapsulates the player's state by storing the user to which it belongs, permissions. groups.
 */
class Player
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Collection
     */
    private $permissions;

    /**
     * @var Group
     */
    private $group;

    public function __construct(User $user, Group $group)
    {
        $this->user = $user;
        $this->group = $group;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function setPermissions(Collection $permissions): Player
    {
        $this->permissions = $permissions;

        return $this;
    }
}
