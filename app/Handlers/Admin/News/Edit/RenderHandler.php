<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\News\Edit;

use App\DataTransferObjects\Admin\News\EditNewsRenderResult;
use App\Exceptions\News\NewsNotFoundException;
use App\Repository\News\NewsRepository;

class RenderHandler
{
    /**
     * @var NewsRepository
     */
    private $repository;

    public function __construct(NewsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $newsId): EditNewsRenderResult
    {
        $news = $this->repository->find($newsId);

        if ($news === null) {
            throw NewsNotFoundException::byId($newsId);
        }

        return new EditNewsRenderResult($news);
    }
}
