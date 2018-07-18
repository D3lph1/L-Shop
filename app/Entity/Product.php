<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * <p>The product represents the entity in the store. The product is characterized by such
 * attributes as the item tied to it, the size of the stack of items sold, the price
 * of 1 stack of products, the server and the category on which this product will be sold.
 * And also, all possible additional characteristics, like, for example, the priority
 * of sorting the goods in the catalog. One item can belong to several products.</p>
 *
 * Visual presentation:
 *
 *                                 +-------------------+
 *                                 |   .     '     ,   |
 *                                 |     _________     |
 *                                 |  _ /_|_____|_\ _  |
 *                                 |    '. \   / .'    |
 *                                 |      '.\ /.'      |
 *                                 |        '.'        |
 *                                 +-------------------+
 *
 * <p>Diamond is {@see \App\Entity\Item}. Package is {@see \App\Entity\Product}.
 * Just like in the store, we can not sell the jewelry without packaging, so the item can not
 * be sold without binding it to the product.</p>
 *
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * Product identifier.
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Price for one stack of items.
     * <p>This price is indicated in conventional units, that is, it is not bound to a specific
     * currency.</p>
     *
     * @ORM\Column(name="price", type="float", nullable=false, unique=false)
     */
    private $price;

    /**
     * Number of items in one stack.
     * <p>For type {@see \App\Entity\Item::type} = {@see \App\Services\Item\Type::ITEM}, the quantity
     * is indicated in pieces, for type {@see \App\Entity\Item::type} =
     * {@see \App\Services\Item\Type::PERMGROUP} the duration is indicated in days.</p>
     *
     * @ORM\Column(name="stack", type="integer", nullable=false, unique=false)
     */
    private $stack;

    /**
     * Priority of sorting products in the catalog. It can be either positive or negative real number.
     *
     * @ORM\Column(name="sort_priority", type="float", nullable=false, unique=false)
     */
    private $sortPriority = 0;

    /**
     * Is the product hidden in the catalog. If true - the product is hidden and can not be purchased.
     *
     * @ORM\Column(name="hidden", type="boolean", nullable=false, unique=false)
     */
    private $hidden = false;

    /**
     * The item that attached to this product.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="products", cascade={"persist"})
     */
    private $item;

    /**
     * The server category in which this product is sold.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(onDelete="CASCADE")
     * })
     */
    private $category;

    /**
     * Product constructor.
     *
     * @param Item     $item
     * @param Category $category
     * @param float    $price
     * @param int      $stack
     */
    public function __construct(Item $item, Category $category, float $price, int $stack)
    {
        $this->setPrice($price);
        $this->setCategory($category);
        $this->setStack($stack);
        $this->setItem($item);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return Product
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int
     */
    public function getStack(): int
    {
        return $this->stack;
    }

    /**
     * @param int $stack
     *
     * @return Product
     */
    public function setStack(int $stack): Product
    {
        $this->stack = $stack;

        return $this;
    }

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * @param Item $item
     *
     * @return Product
     */
    public function setItem(Item $item): Product
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     *
     * @return Product
     */
    public function setCategory(Category $category): Product
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return float
     */
    public function getSortPriority(): float
    {
        return $this->sortPriority;
    }

    /**
     * @param float $sortPriority
     *
     * @return Product
     */
    public function setSortPriority(float $sortPriority): Product
    {
        $this->sortPriority = $sortPriority;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * @param bool $val
     *
     * @return Product
     */
    public function setHidden(bool $val): Product
    {
        $this->hidden = $val;

        return $this;
    }

    /**
     * Creates string representation of object.
     * <p>For example:</p>
     * <p>App\Entity\Product(id=3, price=0.99, stack=64, item={id=1, name="Block of grass",
     * type="item", game_id="minecraft:grass"})</p>
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            '%s(id=%d, price=%F, stack=%d, item={id=%d, name="%s", type="%s", game_id="%s"})',
            self::class,
            $this->getId(),
            $this->getPrice(),
            $this->getStack(),
            $this->getItem()->getId(),
            $this->getItem()->getName(),
            $this->getItem()->getType(),
            $this->getItem()->getGameId()
        );
    }
}
