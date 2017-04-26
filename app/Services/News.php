<?php

namespace App\Services;

use App\Exceptions\News\UnableToCreateNews;
use App\Repositories\NewsRepository;

class News
{
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @param string $title
     * @param string $content
     * @param int $userId
     * @throws UnableToCreateNews
     */
    public function add($title, $content, $userId)
    {
        $result = $this->newsRepository->create([
            'title' => $title,
            'content' => $content,
            'user_id' => $userId
        ]);

        if (!$result) {
            throw new UnableToCreateNews();
        }

        // Remove new data from cache
        \Cache::forget('news');
        \Cache::forget('news.count');
    }
}
