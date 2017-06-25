<?php

namespace App\Services;

use App\Exceptions\News\UnableToCreate;
use App\Exceptions\News\UnableToUpdate;
use App\Repositories\NewsRepository;

/**
 * Class News
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class News
{
    /**
     * @var NewsRepository
     */
    private $newsRepository;

    /**
     * @param NewsRepository $newsRepository
     */
    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @param string $title   News title.
     * @param string $content News content.
     * @param int    $userId  Author identifier.
     *
     * @throws UnableToCreate
     */
    public function add($title, $content, $userId)
    {
        $result = $this->newsRepository->create([
            'title' => $title,
            'content' => $content,
            'user_id' => $userId
        ]);

        if (!$result) {
            throw new UnableToCreate();
        }

        // Remove new data from cache
        $this->forgetNews();
        $this->forgetCount();
    }

    /**
     * @param int $id      Updated news identifier.
     * @param int $title   New title.
     * @param int $content New content.
     *
     * @throws UnableToUpdate
     */
    public function update($id, $title, $content)
    {
        $result = $this->newsRepository->update($id, [
            'title' => $title,
            'content' => $content
        ]);

        if (!$result) {
            throw new UnableToUpdate();
        }

        // Remove new data from cache
        $this->forgetNews();
    }

    /**
     * Load more news.
     *
     * @param int $count    Count news in portion.
     * @param int $serverId Server identifier.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function load($count, $serverId)
    {
        $news = $this->newsRepository->load($count);

        foreach ($news as &$one) {
            $one->content = short_string($one->content, 150);
            $one->link = route('news', [
                'server' => $serverId,
                'id' => $one->id
            ]);
        }
        unset($one);
        $count = count($news);

        if ($count) {
            if ($count < s_get('news.per_page', 15)) {
                $status = 'last portion';
            } else {
                $status = 'success';
            }

            return json_response($status, [
                'news' => $news
            ]);
        }

        return json_response('no more news');
    }

    /**
     * Remove news list from cache.
     */
    public function forgetNews()
    {
        \Cache::forget('news');
    }

    /**
     * Remove news count from cache.
     */
    public function forgetCount()
    {
        \Cache::forget('news.count');
    }

    /**
     * @param int $id Removing news identifier.
     *
     * @return bool|null
     */
    public function delete($id)
    {
        if ($this->newsRepository->exists($id)) {
            return $this->newsRepository->delete($id);
        }

        return false;
    }
}
