<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Pages\Edit;

use App\DataTransferObjects\Admin\Pages\Edit\Edit;
use App\Exceptions\Page\DoesNotExistException;
use App\Repository\Page\PageRepository;

class EditHandler
{
    /**
     * @var PageRepository
     */
    private $repository;

    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Edit $dto): void
    {
        $page = $this->repository->find($dto->getId());
        if ($page === null) {
            throw new DoesNotExistException($dto->getId());
        }

        $page
            ->setTitle($dto->getTitle())
            ->setContent($dto->getContent())
            ->setUrl($dto->getUrl());

        $this->repository->update($page);
    }
}
