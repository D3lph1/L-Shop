<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Products\Edit;

class Edit
{
    /**
     * Editable product identifier.
     *
     * @var int
     */
    private $product;

    /**
     * Item identifier.
     *
     * @var int
     */
    private $item;

    /**
     * Category identifier.
     *
     * @var int
     */
    private $category;

    /**
     * @var float
     */
    private $price;

    /**
     * @var int
     */
    private $stack;

    /**
     * @var float
     */
    private $sortPriority;

    /**
     * @var bool
     */
    private $hidden;

    /**
     * @return int
     */
    public function getProduct(): int
    {
        return $this->product;
    }

    /**
     * @param int $product
     *
     * @return Edit
     */
    public function setProduct(int $product): Edit
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return int
     */
    public function getItem(): int
    {
        return $this->item;
    }

    /**
     * @param int $item
     *
     * @return Edit
     */
    public function setItem(int $item): Edit
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param int $category
     *
     * @return Edit
     */
    public function setCategory(int $category): Edit
    {
        $this->category = $category;

        return $this;
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
     * @return Edit
     */
    public function setPrice(float $price): Edit
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
     * @return Edit
     */
    public function setStack(int $stack): Edit
    {
        $this->stack = $stack;

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
     * @return Edit
     */
    public function setSortPriority(float $sortPriority): Edit
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
     * @param bool $hidden
     *
     * @return Edit
     */
    public function setHidden(bool $hidden): Edit
    {
        $this->hidden = $hidden;

        return $this;
    }
}
