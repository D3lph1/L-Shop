<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Page;

use App\DataTransferObjects\Frontend\Page as DTO;
use App\Exceptions\Page\PageNotFoundException;
use App\Repository\Page\PageRepository;

class VisitHandler
{
    /**
     * @var PageRepository
     */
    private $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Gets the data to render the static page.
     *
     * @param string $url
     *
     * @return DTO
     * @throws PageNotFoundException
     */
    public function handle(string $url): DTO
    {
        $page = $this->pageRepository->findByUrl($url);
        if ($page === null) {
            throw PageNotFoundException::byUrl($url);
        }

        return new DTO($page);
    }
}
