<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\Predicates;

class PermissionPredicate
{
    /**
     * @var string|Regex|null
     */
    private $permission;

    /**
     * @var bool|null
     */
    private $allowed;

    /**
     * @var mixed
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
     * @var bool
     */
    private $anyWorld = true;

    /**
     * @var string|null
     */
    private $contexts;

    /**
     * @var bool
     */
    private $anyContexts = true;

    /**
     * @return Regex|string
     */
    public function getPermission()
    {
        return $this->permission;
    }

    public function setPermission($permission): PermissionPredicate
    {
        $this->permission = $permission;

        return $this;
    }

    public function needAllowed(): ?bool
    {
        return $this->allowed;
    }

    public function setAllowed(?bool $allowed): PermissionPredicate
    {
        $this->allowed = $allowed;

        return $this;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function setServer($server): PermissionPredicate
    {
        $this->server = $server;

        return $this;
    }

    public function setAnyServer(bool $val): PermissionPredicate
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

    public function setWorld(?string $world): PermissionPredicate
    {
        $this->world = $world;

        return $this;
    }

    public function setAnyWorld(bool $val): PermissionPredicate
    {
        $this->anyWorld = $val;

        return $this;
    }

    public function needAnyWorld(): bool
    {
        return $this->anyWorld;
    }

    public function getContexts(): ?string
    {
        return $this->contexts;
    }

    public function setContexts(?string $contexts): PermissionPredicate
    {
        $this->contexts = $contexts;

        return $this;
    }

    public function setAnyContexts(bool $val): PermissionPredicate
    {
        $this->anyContexts = $val;

        return $this;
    }

    public function needAnyContexts(): bool
    {
        return $this->anyContexts;
    }
}
