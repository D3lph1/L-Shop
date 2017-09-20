<?php
declare(strict_types = 1);

namespace App\Repositories\User;

use App\Models\User\EloquentUser;
use Cartalyst\Sentinel\Users\IlluminateUserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class EloquentUserRepository extends IlluminateUserRepository implements UserRepositoryInterface
{
    public function withRolesActivationsBanPaginated(
        array $userColumns,
        array $rolesColumns,
        array $activationsColumns,
        array $banColumns,
        int $perPage = 50): LengthAwarePaginator
    {
        return EloquentUser::select(array_merge($userColumns, ['id']))
            ->with([
                'roles' => function ($query) use ($rolesColumns) {
                    /** @var Builder $query */
                    $query->select($rolesColumns);
                },
                'activations' => function ($query) use ($activationsColumns) {
                    /** @var Builder $query */
                    $query->select($activationsColumns);
                },
                'ban' => function ($query) use ($banColumns) {
                    /** @var Builder $query */
                    $query->select($banColumns);
                }
            ])
            ->paginate($perPage);
    }

    public function search(string $query, array $searchSpecials): array
    {
        /** @var Builder $builder */
        $builder = EloquentUser::select(['id', 'username', 'email', 'balance']);

        $first = $query[0];
        if (in_array($first, $searchSpecials)) {
            $result = $builder
                ->where('balance', $first, str_replace($first, '', $query))
                ->get();
        } else {
            $pattern = '%' . $query . '%';
            $result = $builder
                ->where('id', 'like', $pattern)
                ->orWhere('username', 'like', $pattern)
                ->orWhere('email', 'like', $pattern)
                ->orWhere('balance', 'like', $pattern)
                ->get();
        }

        return $result->toArray();
    }

    public function whereIdIn(array $identifiers, array $columns): iterable
    {
        return EloquentUser::whereIn('id', $identifiers)->get();
    }

    public function truncate(): void
    {
        EloquentUser::truncate();
    }
}
