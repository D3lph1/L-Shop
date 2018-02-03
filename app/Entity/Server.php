<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="servers")
 */
class Server
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="ip", type="string", length=45, nullable=true)
     */
    private $ip;

    /**
     * @ORM\Column(name="port", type="integer", nullable=true)
     */
    private $port;

    /**
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @ORM\Column(name="monitoring_enabled", type="boolean", nullable=false)
     */
    private $monitoringEnabled;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="server")
     */
    private $categories;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->categories = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Server
    {
        $this->name = $name;

        return $this;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp(string $ip)
    {
        $this->ip = $ip;

        return $this;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function setPort(int $port): Server
    {
        $this->port = $port;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): Server
    {
        $this->password = $password;

        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): Server
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function isMonitoringEnabled(): bool
    {
        return $this->monitoringEnabled;
    }

    public function setMonitoringEnabled(bool $monitoringEnabled): Server
    {
        $this->monitoringEnabled = $monitoringEnabled;

        return $this;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): Server
    {
        $this->categories->add($category);

        return $this;
    }
}
