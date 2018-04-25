<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class Permission
{
    public const GLOBAL_CONTEXT = 'global';

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="permission", type="string", length=200, nullable=false)
     */
    protected $permission;

    /**
     * @ORM\Column(name="value", type="boolean")
     */
    private $value = true;

    /**
     * @ORM\Column(name="server", type="string", length=36)
     */
    private $server = self::GLOBAL_CONTEXT;

    /**
     * @ORM\Column(name="world", type="string", length=36)
     */
    private $world = self::GLOBAL_CONTEXT;

    /**
     * @ORM\Column(name="expiry", type="integer")
     */
    private $expireAt = 0;

    /**
     * @ORM\Column(name="contexts", type="string", length=200)
     */
    private $contexts = '{}';

    public function getId(): int
    {
        return $this->id;
    }

    public function getPermission(): string
    {
        return $this->permission;
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    public function setValue(bool $value): Permission
    {
        $this->value = $value;

        return $this;
    }

    public function getServer(): string
    {
        return $this->server;
    }

    public function setServer(string $server): Permission
    {
        $this->server = $server;

        return $this;
    }

    public function getWorld(): string
    {
        return $this->world;
    }

    public function setWorld(string $world): Permission
    {
        $this->world = $world;

        return $this;
    }

    public function getExpiredAt(): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat('U', (string)$this->expireAt);
    }

    public function setExpiredAt(?\DateTimeImmutable $expireAt): Permission
    {
        if ($expireAt !== null) {
            $this->expireAt = $expireAt->getTimestamp();
        } else {
            $this->expireAt = 0;
        }

        return $this;
    }

    public function getContext(): string
    {
        return $this->contexts;
    }

    public function setContexts(string $contexts = '{}'): Permission
    {
        $this->contexts = $contexts;

        return $this;
    }
}
