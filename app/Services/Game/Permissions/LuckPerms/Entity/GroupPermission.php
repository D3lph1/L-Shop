<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lp_group_permissions", indexes={
 *     @ORM\Index(name="name_idx", columns={"name"})
 * })
 */
class GroupPermission extends Permission
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Services\Game\Permissions\LuckPerms\Entity\Group", inversedBy="permissions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="name", referencedColumnName="name")
     * })
     */
    private $group;

    public function __construct(string $permission, Group $group)
    {
        $this->permission = $permission;
        $this->group = $group;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }
}
