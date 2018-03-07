<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Items\Add;

class Result
{
    /**
     * @var Image[]
     */
    private $images = [];

    /**
     * @var Enchantment
     */
    private $enchantments = [];

    public function __construct(array $images, array $enchantments)
    {
        $this->images = $images;
        $this->enchantments = $enchantments;
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
