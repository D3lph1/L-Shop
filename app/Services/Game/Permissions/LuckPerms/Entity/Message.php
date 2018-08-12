<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lp_messages")
 * @ORM\HasLifecycleCallbacks
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="time", type="datetime_immutable", nullable=false)
     */
    private $time;

    /**
     * @ORM\Column(name="msg", type="text")
     */
    private $msg;

    public function __construct(string $msg)
    {
        $this->msg = $msg;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTime(): \DateTimeImmutable
    {
        return $this->time;
    }

    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @ORM\PrePersist
     */
    public function generateTime(): void
    {
        $this->time = new \DateTimeImmutable();
    }
}
