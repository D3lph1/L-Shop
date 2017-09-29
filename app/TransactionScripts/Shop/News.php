<?php
declare(strict_types = 1);

namespace App\TransactionScripts\Shop;

use App\DataTransferObjects\News as DTO;
use App\Exceptions\News\DisabledException;
use App\Exceptions\News\NotFoundExceptions;
use App\Models\News\NewsInterface;
use App\Repositories\News\NewsRepositoryInterface;
use App\Traits\ContainerTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class News
{
    use ContainerTrait;

    /**
     * @var NewsRepositoryInterface
     */
    protected $newsRepository;

    public function __construct(NewsRepositoryInterface $repository)
    {
        $this->newsRepository = $repository;
    }

    public function find(int $newsId): NewsInterface
    {
        $this->checkEnabled();

        $news = $this->newsRepository->find($newsId, ['id', 'title', 'content', 'created_at', 'user_id']);

        if (!$news) {
            throw new NotFoundExceptions($newsId);
        }

        return $news;
    }

    public function adminList(): LengthAwarePaginator
    {
        return $this->newsRepository->paginateWithUsers(
                50,
                ['id', 'title', 'user_id', 'created_at', 'updated_at'],
                ['username']
            );
    }

    public function firstPortion(): iterable
    {
        return $this->newsRepository->getFirstPortion(['id', 'title', 'content', 'user_id', 'created_at']);
    }

    public function load(int $serverId, int $count)
    {
        $this->checkEnabled();

        $news = $this->newsRepository->load($count, ['id', 'title', 'content']);
        $result = [];

        /** @var NewsInterface $one */
        foreach ($news as $one) {
            $tmp = new \stdClass();
            $tmp->title = $one->getTitle();
            $tmp->content = short_string($one->getContent(), 150);
            $tmp->link = route('news', [
                'server' => $serverId,
                'id' => $one->getId()
            ]);

            $result[] = $tmp;
        }

        $count = count($result);

        if ($count) {
            if ($count < s_get('news.per_page', 15)) {
                $status = 'last_portion';
            } else {
                $status = 'success';
            }

            return json_response($status, [
                'news' => $result,
                'more' =>  __('content.shop.news.read_more')
            ]);
        }

        return json_response('no_more_news', [
            'message' => [
                'type' => 'info',
                'text' => __('messages.shop.catalog.news.no_more'),
            ]
        ]);
    }

    public function create(DTO $dto): bool
    {
        $result = $this->newsRepository->create($dto);

        // Remove new data from cache.
        $this->forgetNews();
        $this->forgetCount();

        return (bool)$result;
    }

    public function update(DTO $dto): bool
    {
        $result = $this->newsRepository->update($dto->getId(), $dto);

        // Remove all data from cache.
        $this->forgetNews();

        return $result;
    }

    public function delete(int $newsId): bool
    {
        if ($this->newsRepository->exists($newsId)) {
            $result = $this->newsRepository->delete($newsId);
            if ($result) {
                $this->forgetNews();
                $this->forgetCount();

                return true;
            }

            return false;
        }

        return false;
    }

    /**
     * Remove news list from cache.
     */
    public function forgetNews(): void
    {
        \Cache::forget('news');
    }

    /**
     * Remove news count from cache.
     */
    public function forgetCount(): void
    {
        \Cache::forget('news.count');
    }

    protected function checkEnabled(): void
    {
        if (!s_get('news.enabled')) {
            throw new DisabledException();
        }
    }
}
