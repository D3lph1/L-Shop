<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bans")
 * @ORM\HasLifecycleCallbacks
 */
class Ban
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="until", type="datetime_immutable", nullable=true, unique=false)
     */
    private $until;

    /**
     * @ORM\Column(name="reason", type="string", nullable=true)
     */
    private $reason;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bans")
     */
    private $user;

    /**
     * @ORM\Column(name="created_at", type="datetime_immutable", nullable=false)
     */
    private $createdAt;

    public function __construct(User $user, ?\DateTimeImmutable $until = null)
    {
        $this->user = $user;
        $this->until = $until;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getUntil(): ?\DateTimeImmutable
    {
        return $this->until;
    }

    /**
     * @param \DateTimeImmutable|null $until
     *
     * @return Ban
     */
    public function setUntil(?\DateTimeImmutable $until): Ban
    {
        $this->until = $until;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @param null|string $reason
     *
     * @return Ban
     */
    public function setReason(?string $reason): Ban
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function generateCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
