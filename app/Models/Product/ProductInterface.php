<?php
declare(strict_types = 1);

namespace App\Models\Product;

use App\Models\Category\CategoryInterface;
use App\Models\Item\ItemInterface;
use Carbon\Carbon;

/**
 * Interface ProductInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Product
 */
interface ProductInterface
{
    public function getItem(): ItemInterface;

    public function getCategory(): CategoryInterface;


    public function setId(int $id): ProductInterface;

    public function getId(): ?int;

    public function setPrice(float $price): ProductInterface;

    public function getPrice(): float;

    public function setItemId(int $itemId): ProductInterface;

    public function getItemId(): int;

    public function setStack(float $stackSize): ProductInterface;

    public function getStack(): float ;

    public function setServerId(int $serverId): ProductInterface;

    public function getServerId(): int;

    public function setCategoryId(int $categoryId): ProductInterface;

    public function getCategoryId(): int;

    public function setSortPriority(float $sortPriority): ProductInterface;

    public function getSortPriority(): float;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
