<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\DataTransferObjects\Page;
use App\Models\Page\EloquentPage;
use App\Models\Page\PageInterface;
use App\Repositories\Page\PageRepositoryInterface;
use Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class PageRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories
 */
class EloquentPageRepository implements PageRepositoryInterface
{
    public function create(Page $dto): PageInterface
    {
        return EloquentPage::create([
            'title' => $dto->getTitle(),
            'content' => $dto->getContent(),
            'url' => $dto->getUrl()
        ]);
    }

    public function findByUrl(string $url, array $columns): PageInterface
    {
        $key = "page.{$url}";

        return Cache::get($key, function () use ($columns, $url, $key) {
            $result = EloquentPage::select($columns)
                ->where('url', $url)
                ->get();

            if (isset($result[0])) {
                Cache::put($key, $result, (int)s_get('caching.pages.ttl'));
            }

            return $result;
        });
    }

    public function getPaginated(array $columns): LengthAwarePaginator
    {
        return EloquentPage::paginate(50, $columns);
    }

    public function isUrlUnique(int $pageId, string $url): bool
    {
        return !EloquentPage::where('url', $url)
            ->where('id', '<>', $pageId)
            ->exists();
    }

    public function isUrlUniqueAll(string $url): bool
    {
        return !EloquentPage::where('url', $url)->exists();
    }
}
