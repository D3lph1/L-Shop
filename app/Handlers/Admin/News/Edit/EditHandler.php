<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\News\Edit;

use App\DataTransferObjects\Admin\News\EditNews;
use App\Exceptions\News\NewsNotFoundException;
use App\Repository\News\NewsRepository;

class EditHandler
{
    /**
     * @var NewsRepository
     */
    private $repository;

    public function __construct(NewsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(EditNews $dto): void
    {
        $news = $this->repository->find($dto->getId());

        if ($news === null) {
            throw NewsNotFoundException::byId($dto->getId());
        }

        $news
            ->setTitle($dto->getTitle())
            ->setContent($dto->getContent());

        $this->repository->update($news);
    }
}
