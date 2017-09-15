<?php
declare(strict_types = 1);

namespace App\DataTransferObjects;

/**
 * Class Product
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\DataTransferObjects\Admin
 */
class Product
{
    /**
     * @var int Product identifier
     */
    private $id;

    /**
     * @var float
     */
    private $price;

    /**
     * @var float
     */
    private $stack;

    /**
     * @var int
     */
    private $itemId;

    /**
     * @var int
     */
    private $serverId;

    /**
     * @var int
     */
    private $categoryId;

    /**
     * @var float
     */
    private $sortPriority;

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setStack(float $stack): self
    {
        $this->stack = $stack;

        return $this;
    }

    public function getStack(): float
    {
        return $this->stack;
    }

    public function setItemId(int $itemId): self
    {
        $this->itemId = $itemId;

        return $this;
    }

    public function getItemId(): int
    {
        return $this->itemId;
    }

    public function setServerId(int $serverId): self
    {
        $this->serverId = $serverId;

        return $this;
    }

    public function getServerId(): int
    {
        return $this->serverId;
    }

    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function setSortPriority(float $sortPriority): self
    {
        $this->sortPriority = $sortPriority;

        return $this;
    }

    public function getSortPriority(): float
    {
        return $this->sortPriority;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
