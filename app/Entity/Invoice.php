<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Invoice
{
    /**
     * @ORM\Column(name="via", type="string", length=64, nullable=true)
     */
    private $via;

    /**
     * @ORM\Column(name="completed_at", type="datetime_immutable", nullable=true)
     */
    private $completedAt;

    public function getVia(): string
    {
        return $this->via;
    }

    public function setVia(string $via): Invoice
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

    public function setCompletedAt(\DateTimeImmutable $completedAt): Invoice
    {
        $this->completedAt = $completedAt;

        return $this;
    }
}
