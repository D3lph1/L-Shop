<?php
declare(strict_types = 1);

namespace App\Repositories\Page;

use App\Models\Page\EloquentPage;
use App\Models\Page\PageInterface;
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
    public function create(PageInterface $entity): PageInterface
    {
        return EloquentPage::create(trim_nullable([
            'id' => $entity->getId(),
            'title' => $entity->getTitle(),
            'content' => $entity->getContent(),
            'url' => $entity->getUrl()
        ]));
    }

    public function update(int $id, PageInterface $entity): bool
    {
        return (bool)EloquentPage::where('id', $id)->update([
            'title' => $entity->getTitle(),
            'content' => $entity->getContent(),
            'url' => $entity->getUrl()
        ]);
    }

    public function paginated(): LengthAwarePaginator
    {
        return EloquentPage::paginate(50);
    }

    public function find(int $id, array $columns): ?PageInterface
    {
        return EloquentPage::find($id, $columns);
    }

    public function findByUrl(string $url, array $columns): ?PageInterface
    {
        $key = "page.{$url}";

        return Cache::get($key, function () use ($columns, $url, $key) {
            $result = EloquentPage::select($columns)
                ->where('url', $url)
                ->first();

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

    public function delete(int $id): bool
    {
        return (bool)EloquentPage::where('id', $id)->delete();
    }

    public function truncate(): void
    {
        EloquentPage::truncate();
    }
}
