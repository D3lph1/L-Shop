<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin;

/**
 * Class Product
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
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

    public function __construct(
        float $price,
        float $stack,
        int $itemId,
        int $serverId,
        int $categoryId,
        float $sortPriority)
    {
        $this->price = $price;
        $this->stack = $stack;
        $this->itemId = $itemId;
        $this->serverId = $serverId;
        $this->categoryId = $categoryId;
        $this->sortPriority = $sortPriority;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStack(): float
    {
        return $this->stack;
    }

    public function getItemId(): int
    {
        return $this->itemId;
    }

    public function getServerId(): int
    {
        return $this->serverId;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getSortPriority(): float
    {
        return $this->sortPriority;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
