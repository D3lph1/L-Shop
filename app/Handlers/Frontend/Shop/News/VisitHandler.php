<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\News;

use App\Entity\News;
use App\Exceptions\News\DoesNotExistException;
use App\Repository\News\NewsRepository;

class VisitHandler
{
    /**
     * @var NewsRepository
     */
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @param int $newsId
     *
     * @return News
     * @throws DoesNotExistException
     */
    public function handle(int $newsId): News
    {
        $news = $this->newsRepository->find($newsId);
        if ($news === null) {
            throw new DoesNotExistException($newsId);
        }

        return $news;
    }
}
