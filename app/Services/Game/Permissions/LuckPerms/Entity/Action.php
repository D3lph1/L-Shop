<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="lp_actions")
 * @ORM\HasLifecycleCallbacks
 */
class Action
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="time", type="bigint", length=20)
     */
    private $time;

    /**
     * @ORM\Column(name="actor_uuid", type="string", length=36)
     */
    private $actorUuid;

    /**
     * @ORM\Column(name="actor_name", type="string", length=100, nullable=true)
     */
    private $actorName;

    /**
     * @ORM\Column(name="type", type="string", length=1, options={"fixed" = true})
     */
    private $type;

    /**
     * @ORM\Column(name="acted_uuid", type="string", length=36)
     */
    private $actedUuid;

    /**
     * @ORM\Column(name="acted_name", type="string", length=36)
     */
    private $actedName;

    /**
     * @ORM\Column(name="action", type="string", length=300, nullable=true)
     */
    private $action;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTime(): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat('U', $this->time);
    }

    public function getActorUuid(): UuidInterface
    {
        return Uuid::fromString($this->actorUuid);
    }

    public function getActorName(): ?string
    {
        return $this->actorName;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getActedUuid(): UuidInterface
    {
        return Uuid::fromString($this->actedUuid);
    }

    public function getActedName(): string
    {
        return $this->actedName;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * @ORM\PrePersist
     */
    public function generateTime(): void
    {
        $this->time = (new \DateTimeImmutable())->getTimestamp();
    }
}
