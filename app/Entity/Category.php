<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Each server in the store is divided into categories. In each category, an unlimited number
 * of products can be sold. This division is convenient, if you want to divide the products
 * on some basis.
 *
 * @see \App\Entity\Server
 * @see \App\Entity\Product
 *
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Category
{
    /**
     * Category identifier.
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The category name will be displayed on the store pages.
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Server", inversedBy="categories", cascade={"persist"})
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(onDelete="CASCADE")
     * })
     */
    private $server;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category")
     */
    private $products;

    public function __construct(string $name, Server $server)
    {
        $this->name = $name;
        $this->server = $server;
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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    public function setServer(Server $server): Category
    {
        $this->server = $server;

        return $this;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): Category
    {
        $this->products->add($product);

        return $this;
    }

    /**
     * Creates string representation of object.
     * <p>For example:</p>
     * <p>App\Entity\Category(id=2, name="Blocks")</p>
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
