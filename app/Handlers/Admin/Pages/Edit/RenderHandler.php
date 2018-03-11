<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Pages\Edit;

use App\DataTransferObjects\Admin\Pages\Edit\Page;
use App\Exceptions\Page\DoesNotExistException;
use App\Repository\Page\PageRepository;

class RenderHandler
{
    /**
     * @var PageRepository
     */
    private $repository;

    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $pageId): Page
    {
        $page = $this->repository->find($pageId);
        if ($page === null) {
            throw new DoesNotExistException($pageId);
        }

        return new Page($page);
    }
}
