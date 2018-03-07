<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Items\Edit;

use App\DataTransferObjects\Admin\Items\Add\Image;

class Result
{
    /**
     * @var Item
     */
    private $item;

    /**
     * @var Image[]
     */
    private $images;

    /**
     * @var Enchantment[]
     */
    private $enchantments;

    public function __construct(Item $item, array $images, array $enchantments)
    {
        $this->item = $item;
        $this->images = $images;
        $this->enchantments = $enchantments;
    }

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @return Enchantment[]
     */
    public function getEnchantments(): array
    {
        return $this->enchantments;
    }
}
