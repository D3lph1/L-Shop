<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lp_user_permissions", indexes={
 *     @ORM\Index(name="uuid_idx", columns={"uuid"})
 * })
 */
class PlayerPermission extends Permission
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Services\Game\Permissions\LuckPerms\Entity\Player")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="uuid", referencedColumnName="uuid")
     * })
     */
    private $player;

    public function __construct(string $permission, Player $player)
    {
        $this->permission = $permission;
        $this->player = $player;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }
}
