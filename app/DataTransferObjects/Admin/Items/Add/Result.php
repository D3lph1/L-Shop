<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Items\Add;

class Result
{
    /**
     * @var Image[]
     */
    private $images;

    public function __construct(array $images)
    {
        $this->images = $images;
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }
}
