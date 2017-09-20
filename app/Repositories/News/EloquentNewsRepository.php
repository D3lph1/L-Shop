<?php
declare(strict_types=1);

namespace App\Repositories\News;

use App\DataTransferObjects\News;
use App\Models\News\EloquentNews;
use App\Models\News\NewsInterface;
use Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EloquentNewsRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\News
 */
class EloquentNewsRepository implements NewsRepositoryInterface
{
    public function create(News $dto): ?NewsInterface
    {
        return EloquentNews::create([
            'title' => $dto->getTitle(),
            'content' => $dto->getContent(),
            'user_id' => $dto->getUserId()
        ]);
    }

    public function update(int $id, News $dto): bool
    {
        return EloquentNews::where('id', $id)->update([
            'title' => $dto->getTitle(),
            'content' => $dto->getContent(),
            'user_id' => $dto->getUserId()
        ]);
    }

    public function delete(int $id): bool
    {
        return (bool)EloquentNews::where('id', $id)->delete();
    }

    public function find(int $id, array $columns): ?NewsInterface
    {
        return EloquentNews::find($id, $columns);
    }

    public function getFirstPortion(array $columns): iterable
    {
        return Cache::get('news', function () use ($columns) {
            $result = EloquentNews::select($columns)
                ->orderBy('created_at', 'DESC')
                ->limit(s_get('news.first_portion', 15))
                ->get();

            Cache::add('news', $result, 1);

            return $result;
        });
    }

    public function count(): int
    {
        return Cache::get('news.count', function () {
            $result = EloquentNews::count();
            Cache::add('news.count', $result, 1);

            return $result;
        });
    }

    public function exists(int $id): bool
    {
        return EloquentNews::where('id', $id)
            ->exists();
    }

    public function load(int $count, array $columns): iterable
    {
        return EloquentNews::select($columns)
            ->orderBy('created_at', 'DESC')
            ->offset($count)
            ->limit(s_get('news.per_page', 15))
            ->get();
    }

    public function paginateWithUsers(int $perPage, array $newsColumns, array $userColumns): LengthAwarePaginator
    {
        return EloquentNews::select(array_merge($newsColumns, ['news.user_id']))
            ->with([
                'author' => function ($query) use ($userColumns) {
                    /** @var Builder $query */
                    $query->select(array_merge($userColumns, ['users.id']));
                }
            ])
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    public function truncate(): void
    {
        EloquentNews::truncate();
    }
}
