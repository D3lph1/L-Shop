<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository extends BaseRepository
{
    const MODEL = Page::class;

    /**
     * Get static page from database or cache
     *
     * @param string $url
     * @param array  $columns
     *
     * @return mixed
     */
    public function findByUrl($url, $columns = [])
    {
        $key = "page.{$url}";
        $columns = $this->prepareColumns($columns);

        return \Cache::get($key, function () use ($columns, $url, $key) {
            $result = Page::select($columns)
                ->where('url', $url)
                ->get();

            if (isset($result[0])) {
                \Cache::put($key, $result, (int)s_get('caching.pages.ttl'));
            }

            return $result;
        });
    }

    /**
     * Get all static pages paginated
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginated()
    {
        return Page::paginate(50, ['id', 'title', 'url', 'created_at', 'updated_at']);
    }

    /**
     * @param int    $id
     * @param string $url
     *
     * @return bool
     */
    public function isUrlUnique($id, $url)
    {
        return !(bool)Page::where('url', $url)
            ->where('id', '<>', $id)
            ->count();
    }
}
