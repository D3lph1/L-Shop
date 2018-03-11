<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Pages;

use App\Exceptions\Page\DoesNotExistException;
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

    public function handle(int $pageId): void
    {
        $page = $this->repository->find($pageId);
        if ($page === null) {
            throw new DoesNotExistException($pageId);
        }

        $this->repository->remove($page);
    }
}
