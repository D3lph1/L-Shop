<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend;

use App\Entity\Page as Entity;

class Page implements \JsonSerializable
{
    /**
     * @var Entity
     */
    private $page;

    public function __construct(Entity $page)
    {
        $this->page = $page;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'title' => $this->page->getTitle(),
            'content' => $this->page->getContent()
        ];
    }
}
