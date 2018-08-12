<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="throttles")
 * @ORM\HasLifecycleCallbacks
 */
class Throttle
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="ip", type="string", nullable=true)
     */
    private $ip;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\Column(name="until", type="datetime_immutable", nullable=false)
     */
    private $until;

    /**
     * @ORM\Column(name="created_at", type="datetime_immutable", nullable=false)
     */
    private $createdAt;

    public function __construct(\DateTimeImmutable $until)
    {
        $this->until = $until;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    public function getUser():  User
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getUntil(): \DateTimeImmutable
    {
        return $this->until;
    }

    /**
     * @return \DateTimeImmutable
     */
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
