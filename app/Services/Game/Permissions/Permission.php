<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions;

use App\Entity\Server;

/**
 * Class Permission
 * Represents the permission of a user or group.
 */
class Permission
{
    public const GLOBAL_WORLD = 'global';

    /**
     * Raw permission name. This name was obtained directly from the repository and has not
     * yet been processed.
     *
     * @example minecraft.command.gamemode
     * @example group.custom
     *
     * @var string
     */
    private $name;

    /**
     * If it is true, the user owns this permission. Otherwise - does not own.
     *
     * @var bool
     */
    private $allowed;

    /**
     * The server on which this permission is available. If null is available globally.
     *
     * @var Server|null
     */
    private $server;

    /**
     * The world in which this permission applies.
     *
     * @var string|null
     */
    private $world;

    /**
     * Date and time to which the user owns this privilege. If null - privilege does not expire ever.
     *
     * @var \DateTimeImmutable|null
     */
    private $expireAt;

    /**
     * Contexts of permissions.
     *
     * @var string
     */
    private $contexts;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isAllowed(): bool
    {
        return $this->allowed;
    }

    public function setAllowed(bool $allowed): Permission
    {
        $this->allowed = $allowed;

        return $this;
    }

    public function getServer(): ?Server
    {
        return $this->server;
    }

    public function setServer(?Server $server): Permission
    {
        $this->server = $server;

        return $this;
    }

    public function getWorld(): ?string
    {
        if ($this->world !== self::GLOBAL_WORLD) {
            return $this->world;
        }

        return null;
    }

    public function setWorld(?string $world): Permission
    {
        if ($world === null) {
            $this->world = self::GLOBAL_WORLD;
        } else {
            $this->world = $world;
        }

        return $this;
    }

    public function getExpireAt(): ?\DateTimeImmutable
    {
        return $this->expireAt;
    }

    public function setExpireAt(?\DateTimeImmutable $expireAt): Permission
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    public function getContexts(): string
    {
        return $this->contexts;
    }

    public function setContexts(string $contexts): Permission
    {
        $this->contexts = $contexts;

        return $this;
    }
}
