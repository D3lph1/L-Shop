<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lp_groups")
 */
class Group
{
    public const DEFAULT = 'default';

    /**
     * @ORM\Id
     * @ORM\Column(name="`name`", type="string", length=36)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Services\Game\Permissions\LuckPerms\Entity\GroupPermission", mappedBy="group", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="name", referencedColumnName="name")
     * })
     */
    private $permissions;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->permissions = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPermissions(): Collection
    {
        return $this->permissions;
    }
}
