<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="price", type="float", nullable=false, unique=false)
     */
    private $price;

    /**
     * @ORM\Column(name="stack", type="integer", nullable=false, unique=false)
     */
    private $stack;

    /**
     * @ORM\Column(name="sort_priority", type="float", nullable=false, unique=false)
     */
    private $sortPriority = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="products", cascade={"persist"})
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     */
    private $category;

    public function __construct(Item $item, Category $category, float $price, int $stack)
    {
        $this->setPrice($price);
        $this->setCategory($category);
        $this->setStack($stack);
        $this->setItem($item);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): Product
    {
        $this->price = $price;

        return $this;
    }

    public function getStack(): int
    {
        return $this->stack;
    }

    public function setStack(int $stack): Product
    {
        $this->stack = $stack;

        return $this;
    }

    public function getItem(): Item
    {
        return $this->item;
    }

    public function setItem(Item $item): Product
    {
        $this->item = $item;

        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): Product
    {
        $this->category = $category;

        return $this;
    }

    public function getSortPriority(): float
    {
        return $this->sortPriority;
    }

    public function setSortPriority(float $sortPriority): Product
    {
        $this->sortPriority = $sortPriority;

        return $this;
    }
}
