<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Each server in the store is divided into categories. In each category, an unlimited number of
 * products can be sold. This division is convenient, if you want to divide the goods on some
 * basis.
 *
 *                                                             Tree of structure
 *
 *                                                      +---------------------------+
 *                                                      | {@see \App\Entity\Server} |
 *                                                      +-------------+-------------+
 *                                                          ( Has many categories)
 *                                                                    |
 *                                 +----------------------------------+----------------------------------+
 *                                 |                                                                     |
 *                  +--------------+--------------+                                       +--------------+--------------+
 *                  | {@see \App\Entity\Category} |                                       | {@see \App\Entity\Category} |
 *                  +--------------+--------------+                                       +--------------+--------------+
 *                       ( Has many products )                                                   (Has many products)
 *                                 |                                                                     |
 *                +----------------+-----------------+                                  +----------------+-----------------+
 *                |                                  |                                  |                                  |
 * +--------------+-------------+     +--------------+-------------+     +--------------+-------------+     +--------------+-------------+
 * | {@see \App\Entity\Product} |     | {@see \App\Entity\Product} |     | {@see \App\Entity\Product} |     | {@see \App\Entity\Product} |
 * +--------------+-------------+     +--------------+-------------+     +--------------+-------------+     +--------------+-------------+
 *         ( Has one item )                   ( Has one item )                   ( Has one item )                   ( Has one item )
 *                |                                  |                                  |                                  |
 *   +------------+------------+        +------------+------------+        +------------+------------+        +------------+------------+
 *   | {@see \App\Entity\Item} |        | {@see \App\Entity\Item} |        | {@see \App\Entity\Item} |        | {@see \App\Entity\Item} |
 *   +-------------------------+        +-------------------------+        +-------------------------+        +-------------------------+
 *
 * @see \App\Entity\Category
 *
 * @ORM\Entity
 * @ORM\Table(name="servers")
 */
class Server
{
    /**
     * Server identifier.
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The server name will be displayed on the store pages.
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * The IP address of the game server is used to communicate with it using the RCON protocol.
     *
     * @ORM\Column(name="ip", type="string", length=45, nullable=true)
     */
    private $ip;

    /**
     * The network RCON port of the game server is used to communicate with it using the RCON protocol.
     *
     * @ORM\Column(name="port", type="integer", nullable=true)
     */
    private $port;

    /**
     * RCON password is used to gain access to the game server using the RCON protocol.
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * The full name of the distributor class (together with the name of the distributor), which
     * will be used to issue the goods to the player.
     *
     * @see \App\Services\Purchasing\Distributors\Distributor
     *
     * @ORM\Column(name="distributor", type="string", length=255, nullable=false)
     */
    private $distributor;

    /**
     * Is the server turned on (Is it allowed to purchase products on this server)?
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * Do I need to monitor online statistics on this server?
     *
     * @ORM\Column(name="monitoring_enabled", type="boolean", nullable=false)
     */
    private $monitoringEnabled;

    /**
     * Categories that belong to this server.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="server", cascade={"persist"})
     */
    private $categories;

    /**
     * Server constructor.
     *
     * @param string $name
     * @param string $distributor
     */
    public function __construct(string $name, string $distributor)
    {
        $this->name = $name;
        $this->distributor = $distributor;
        $this->categories = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Server
     */
    public function setName(string $name): Server
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     *
     * @return $this
     */
    public function setIp(?string $ip): Server
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPort(): ?int
    {
        return $this->port;
    }

    /**
     * @param int|null $port
     *
     * @return Server
     */
    public function setPort(?int $port): Server
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     *
     * @return Server
     */
    public function setPassword(?string $password): Server
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $distributor
     *
     * @return $this
     */
    public function setDistributor(string $distributor): Server
    {
        $this->distributor = $distributor;

        return $this;
    }

    /**
     * @return string
     */
    public function getDistributor(): string
    {
        return $this->distributor;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return Server
     */
    public function setEnabled(bool $enabled): Server
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMonitoringEnabled(): bool
    {
        return $this->monitoringEnabled;
    }

    /**
     * @param bool $monitoringEnabled
     *
     * @return Server
     */
    public function setMonitoringEnabled(bool $monitoringEnabled): Server
    {
        $this->monitoringEnabled = $monitoringEnabled;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * Creates string representation of object.
     * <p>For example:</p>
     * <p>App\Entity\Server(id=2, name="MMO")</p>
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            '%s(id=%d, name="%s")',
            self::class,
            $this->getId(),
            $this->getName()
        );
    }
}
