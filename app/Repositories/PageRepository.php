<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Page;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class PageRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories
 */
class PageRepository extends BaseRepository
{
    const MODEL = Page::class;

    /**
     * Get static page from database or cache.
     */
    public function findByUrl(string $url, array $columns = []): Page
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
     * Get all static pages paginated.
     */
    public function getPaginated(array $columns = []): LengthAwarePaginator
    {
        return Page::paginate(50, $this->prepareColumns($columns));
    }

    public function isUrlUnique(int $id, string $url): bool
    {
        return !(bool)Page::where('url', $url)
            ->where('id', '<>', $id)
            ->count();
    }

    public function isUrlUniqueAll(string $url): bool
    {
        return !(bool)Page::where('url', $url)
            ->count();
    }
}
