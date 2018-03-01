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

    public function __construct(Item $item, array $images)
    {
        $this->item = $item;
        $this->images = $images;
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
}
