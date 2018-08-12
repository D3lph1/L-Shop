<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\News;

use App\Exceptions\News\NewsNotFoundException;
use App\Repository\News\NewsRepository;

class DeleteHandler
{
    /**
     * @var NewsRepository
     */
    private $repository;

    public function __construct(NewsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $newsId): void
    {
        $news = $this->repository->find($newsId);

        if ($news === null) {
            throw NewsNotFoundException::byId($newsId);
        }

        $this->repository->remove($news);
    }
}
