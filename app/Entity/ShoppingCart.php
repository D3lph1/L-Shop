<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @see http://rubukkit.org/threads/admn-shoppingcart-reloaded-1-2-plagin-dlja-vydachi-predmetov-iz-bd-1-4-7-1-7-2r-0-3.28052/
 *
 * @ORM\Entity
 * @ORM\Table(name="shopping_cart")
 */
class ShoppingCart
{
    public const TYPE_ITEM = 'item';

    public const TYPE_PERMGROUP = 'permgroup';

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Server")
     * @ORM\JoinColumn(name="server", onDelete="CASCADE")
     */
    private $server;

    /**
     * @ORM\Column(name="player", type="string", nullable=false)
     */
    private $player;

    /**
     * @ORM\Column(name="type", type="string", length=16, nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(name="item", type="string", nullable=false)
     */
    private $signature;

    /**
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private $amount;

    /**
     * @ORM\Column(name="extra", type="text", nullable=true)
     */
    private $extra;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Distribution")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="distribution_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $distribution;

    public function __construct(Distribution $distribution)
    {
        $this->distribution = $distribution;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    public function setServer(Server $server): ShoppingCart
    {
        $this->server = $server;

        return $this;
    }

    public function getPlayer(): string
    {
        return $this->server;
    }

    public function setPlayer(string $player): ShoppingCart
    {
        $this->player = $player;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): ShoppingCart
    {
        $this->type = $type;

        return $this;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }

    public function setSignature(string $signature): ShoppingCart
    {
        $this->signature = $signature;

        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): ShoppingCart
    {
        $this->amount = $amount;

        return $this;
    }

    public function getExtra(): ?string
    {
        return $this->extra;
    }

    public function setExtra(?string $extra): ShoppingCart
    {
        $this->extra = $extra;

        return $this;
    }

    public function getDistribution(): Distribution
    {
        return $this->distribution;
    }

    public function setPurchaseItem(Distribution $distribution)
    {
        $this->distribution = $distribution;

        return $this;
    }
}
