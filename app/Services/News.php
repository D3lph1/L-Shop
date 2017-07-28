<?php

namespace App\Services;

use App\DataTransferObjects\Admin\News as DTO;
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
     * @param DTO $dto
     *
     * @return bool
     */
    public function add(DTO $dto)
    {
        $result = $this->newsRepository->create([
            'title' => $dto->getTitle(),
            'content' => $dto->getContent(),
            'user_id' => $dto->getUserId()
        ]);

        // Remove new data from cache.
        $this->forgetNews();
        $this->forgetCount();

        return (bool)$result;
    }

    /**
     * Update given news.
     *
     * @param DTO $dto
     *
     * @return bool
     */
    public function update(DTO $dto)
    {
        $result = $this->newsRepository->update($dto->getId(), [
            'title' => $dto->getTitle(),
            'content' => $dto->getContent()
        ]);

        // Remove new data from cache
        $this->forgetNews();

        return $result;
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
                $status = 'last_portion';
            } else {
                $status = 'success';
            }

            return json_response($status, [
                'news' => $news
            ]);
        }

        return json_response('no_more_news', [
            'message' => [
                'type' => 'info',
                'text' => __('messages.shop.catalog.news.no_more'),
            ]
        ]);
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
            $result = $this->newsRepository->delete($id);
            if ($result) {
                $this->forgetNews();
                $this->forgetCount();

                return true;
            }

            return false;
        }

        return false;
    }
}
