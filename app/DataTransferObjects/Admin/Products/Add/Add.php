<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Products\Add;

class Add
{
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
    public function getItem(): int
    {
        return $this->item;
    }

    /**
     * @param int $item
     *
     * @return Add
     */
    public function setItem(int $item): Add
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
     * @return Add
     */
    public function setCategory(int $category): Add
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
     * @return Add
     */
    public function setPrice(float $price): Add
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
     * @return Add
     */
    public function setStack(int $stack): Add
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
     * @return Add
     */
    public function setSortPriority(float $sortPriority): Add
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
     * @return Add
     */
    public function setHidden(bool $hidden): Add
    {
        $this->hidden = $hidden;

        return $this;
    }
}
