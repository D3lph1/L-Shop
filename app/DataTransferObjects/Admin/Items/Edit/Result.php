<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Items\Edit;

use App\DataTransferObjects\Admin\Items\Add\Image;
use App\Services\Response\JsonRespondent;

class Result implements JsonRespondent
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
     * @inheritDoc
     */
    public function response(): array
    {
        return [
            'item' => $this->item,
            'images' => $this->images,
            'enchantments' => $this->enchantments
        ];
    }
}
