<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Page;

use App\Entity\Page;
use App\Exceptions\Page\DoesNotExistException;
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
     * @param string $url
     *
     * @return Page
     * @throws DoesNotExistException
     */
    public function handle(string $url): Page
    {
        $page = $this->pageRepository->findByUrl($url);
        if ($page === null) {
            throw new DoesNotExistException($url);
        }

        return $page;
    }
}
