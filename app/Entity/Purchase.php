<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="purchases")
 * @ORM\HasLifecycleCallbacks
 */
class Purchase
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="cost", type="float", nullable=false)
     */
    private $cost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\Column(name="player", type="string", nullable=true, unique=false)
     */
    private $player;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PurchaseItem", mappedBy="purchase", cascade={"persist"})
     */
    private $items;

    /**
     * @ORM\Column(name="ip", type="string", length=45, nullable=true)
     */
    private $ip;

    /**
     * @ORM\Column(name="created_at", type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="via", type="string", length=64, nullable=true)
     */
    private $via;

    /**
     * @ORM\Column(name="completed_at", type="datetime_immutable", nullable=true)
     */
    private $completedAt;

    public function __construct(float $cost, ?string $ip = null)
    {
        $this->cost = $cost;
        $this->items = new ArrayCollection();
        $this->ip = $ip;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCost(): float
    {
        return $this->cost;
    }

    public function setCost(float $cost): Purchase
    {
        $this->cost = $cost;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): Purchase
    {
        $this->user = $user;

        return $this;
    }

    public function getPlayer(): ?string
    {
        return $this->player;
    }

    public function setPlayer(string $player): Purchase
    {
        $this->player = $player;

        return $this;
    }

    public function isAnonymously(): bool
    {
        return $this->user === null;
    }

    /**
     * @return Collection
     */
    public function getItems(): Collection
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->items;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function getVia(): ?string
    {
        return $this->via;
    }

    public function setVia(?string $via): Purchase
    {
        $this->via = $via;

        return $this;
    }

    public function getCompletedAt(): ?\DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function isCompleted(): bool
    {
        return $this->getCompletedAt() !== null;
    }

    public function setCompletedAt(\DateTimeImmutable $completedAt): Purchase
    {
        $this->completedAt = $completedAt;

        return $this;
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

    public function __toString(): string
    {
        return sprintf(
            '%s(id=%d, cost=%F, %s, invoice={via=%s, completed_at=%s})',
            self::class,
            $this->getId(),
            $this->getCost(),
            $this->getUser() === null ?
                sprintf('player="%s"', $this->getPlayer()) :
                sprintf('user={%s}', $this->getUser()),
            $this->isCompleted() ? "\"{$this->getVia()}\"" : 'null',
            $this->isCompleted() ? "\"{$this->getCompletedAt()}\"" : 'null'
        );
    }
}
