<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\Predicates;

use App\Entity\Server;
use App\Services\Game\Permissions\Player;

class FilterPermissionsPredicate
{
    /**
     * @var Player
     */
    private $player;

    /**
     * @var string|Regex
     */
    private $permission;

    /**
     * @var bool|null
     */
    private $allowed;

    /**
     * @var Server|null
     */
    private $server;

    /**
     * @var bool
     */
    private $anyServer = true;

    /**
     * @var string|null
     */
    private $world;

    /**
     * @var string|null
     */
    private $contexts;

    /**
     * AllowedPredicate constructor.
     *
     * @param Player       $player
     * @param string|Regex $permission
     */
    public function __construct(Player $player, $permission)
    {
        $this->player = $player;
        $this->permission = $permission;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return Regex|string
     */
    public function getPermission()
    {
        return $this->permission;
    }

    public function needAllowed(): ?bool
    {
        return $this->allowed;
    }

    public function setAllowed(?bool $allowed): FilterPermissionsPredicate
    {
        $this->allowed = $allowed;

        return $this;
    }

    public function getServer(): ?Server
    {
        return $this->server;
    }

    public function setServer(?Server $server): FilterPermissionsPredicate
    {
        $this->server = $server;

        return $this;
    }

    public function setAnyServer(bool $val): FilterPermissionsPredicate
    {
        $this->anyServer = $val;

        return $this;
    }

    public function needAnyServer(): bool
    {
        return $this->anyServer;
    }

    public function getWorld(): ?string
    {
        return $this->world;
    }

    public function setWorld(?string $world): FilterPermissionsPredicate
    {
        $this->world = $world;

        return $this;
    }

    public function getContexts(): ?string
    {
        return $this->contexts;
    }

    public function setContexts(?string $contexts): FilterPermissionsPredicate
    {
        $this->contexts = $contexts;

        return $this;
    }
}
