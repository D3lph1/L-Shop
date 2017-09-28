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


    public function getId(): int;

    public function getPrice(): float;

    public function getItemId(): int;

    public function getStack(): float ;

    public function getServerId(): int;

    public function getCategoryId(): int;

    public function getSortPriority(): float;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
