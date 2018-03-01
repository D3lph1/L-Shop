<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="items")
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="`name`", type="string", length=255, nullable=false, unique=false)
     */
    private $name;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="type", type="string", length=32, nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(name="game_id", type="string", length=255, nullable=false)
     */
    private $gameId;

    /**
     * @ORM\Column(name="extra", type="text", nullable=true)
     */
    private $extra;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="item")
     */
    private $products;

    public function __construct(string $name, string $type, string $gameId)
    {
        $this->setName($name);
        $this->setType($type);
        $this->setGameId($gameId);
        $this->products = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Item
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Item
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Item
    {
        $this->type = $type;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): Item
    {
        $this->image = $image;

        return $this;
    }

    public function getGameId(): string
    {
        return $this->gameId;
    }

    public function setGameId(string $gameId): Item
    {
        $this->gameId = $gameId;

        return $this;
    }

    public function getExtra(): ?string
    {
        return $this->extra;
    }

    public function setExtra(?string $extra): Item
    {
        $this->extra = $extra;

        return $this;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): Item
    {
        $this->products->add($product);

        return $this;
    }
}
