<?php

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
     * @var int
     */
    private $id;

    /**
     * @var float
     */
    private $price;

    /**
     * @var int
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

    /**
     * Product constructor.
     *
     * @param float $price
     * @param int|float $stack
     * @param int $itemId
     * @param int $serverId
     * @param int $categoryId
     * @param float $sortPriority
     */
    public function __construct($price, $stack, $itemId, $serverId, $categoryId, $sortPriority)
    {
        $this->price = (float)$price;
        $this->stack = $stack;
        $this->itemId = (int)$itemId;
        $this->serverId = (int)$serverId;
        $this->categoryId = (int)$categoryId;
        $this->sortPriority = (float)$sortPriority;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getStack()
    {
        return $this->stack;
    }

    /**
     * @return int
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @return int
     */
    public function getServerId()
    {
        return $this->serverId;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @return float
     */
    public function getSortPriority()
    {
        return $this->sortPriority;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }
}
