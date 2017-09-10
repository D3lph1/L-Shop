<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\News;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class NewsRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories
 */
class NewsRepository extends BaseRepository
{
    const MODEL = News::class;

    /**
     * Get first portion of the news.
     */
    public function getFirstPortion(): Collection
    {
        return \Cache::get('news', function () {
            $result = News::select(['id', 'title', 'content'])
                ->orderBy('created_at', 'DESC')
                ->limit(s_get('news.first_portion', 15))
                ->get();

            \Cache::add('news', $result, 1);

            return $result;
        });
    }

    /**
     * Get all news count.
     */
    public function count(): int
    {
        return \Cache::get('news.count', function () {
            $result = News::count();
            \Cache::add('news.count', $result, 1);

            return $result;
        });
    }

    /**
     * Load more news.
     *
     * @param int $count Count of news for load.
     *
     * @return Collection
     */
    public function load(int $count): Collection
    {
        return News::select(['id', 'title', 'content'])
            ->orderBy('created_at', 'DESC')
            ->offset($count)
            ->limit(s_get('news.per_page', 15))
            ->get();
    }

    /**
     * Retrieve and paginate news.
     *
     * @param int   $perPage Count of news in one pagination page.
     * @param array $columns Columns for sampling.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage, array $columns = []): LengthAwarePaginator
    {
        $columns = $this->prepareColumns($columns);

        return News::select($columns)->orderBy('created_at', 'DESC')->paginate($perPage);
    }
}
