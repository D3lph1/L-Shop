<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="persistences", indexes={@ORM\Index(name="search_idx", columns={"code", "user_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class Persistence
{
    public const CODE_LENGTH = 64;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="code", type="string", length=64, unique=true)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\Column(name="created_at", type="datetime_immutable", nullable=false)
     */
    private $createdAt;

    public function __construct(string $code, User $user)
    {
        $this->code = $code;
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function generateCreatedAt()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function isExpired(): bool
    {
        return $this->getCreatedAt()->getTimestamp() + config('auth.persistence.lifetime') < time();
    }
}
