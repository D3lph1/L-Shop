<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\News;

use App\DataTransferObjects\Frontend\News\News as DTO;
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
     * @return DTO
     * @throws DoesNotExistException
     */
    public function handle(int $newsId): DTO
    {
        $news = $this->newsRepository->find($newsId);
        if ($news === null) {
            throw new DoesNotExistException($newsId);
        }

        return new DTO($news);
    }
}
