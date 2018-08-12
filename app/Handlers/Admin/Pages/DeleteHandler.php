<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Pages;

use App\Exceptions\Page\PageNotFoundException;
use App\Repository\Page\PageRepository;

class DeleteHandler
{
    /**
     * @var PageRepository
     */
    private $repository;

    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $pageId
     *
     * @throws PageNotFoundException
     */
    public function handle(int $pageId): void
    {
        $page = $this->repository->find($pageId);
        if ($page === null) {
            throw PageNotFoundException::byId($pageId);
        }

        $this->repository->remove($page);
    }
}
