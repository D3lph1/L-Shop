<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lp_players")
 */
class Player
{
    /**
     * @ORM\Id
     * @ORM\Column(name="uuid", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $uuid;

    /**
     * @ORM\Column(name="username", type="string", length=32)
     */
    private $username;

    /**
     * @ORM\ManyToOne(targetEntity="App\Services\Game\Permissions\LuckPerms\Entity\Group")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="primary_group", referencedColumnName="name")
     * })
     */
    private $primaryGroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Services\Game\Permissions\LuckPerms\Entity\PlayerPermission", mappedBy="player", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="uuid", referencedColumnName="uuid")
     * })
     */
    private $permissions;

    public function __construct(User $user, Group $primaryGroup)
    {
        $this->username = $user->getUsername();
        $this->primaryGroup = $primaryGroup;
        $this->permissions = new ArrayCollection();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getPrimaryGroup(): Group
    {
        return $this->primaryGroup;
    }

    public function getPermissions(): Collection
    {
        return $this->permissions;
    }
}
