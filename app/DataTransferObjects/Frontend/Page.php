<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend;

use App\Entity\Page as Entity;
use App\Services\Response\JsonRespondent;

/**
 * Class Page
 * This data transfer object is used to serialize the data for rendering a static page.
 */
class Page implements JsonRespondent
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
    public function response(): array
    {
        return [
            'title' => $this->page->getTitle(),
            'content' => $this->page->getContent()
        ];
    }
}
