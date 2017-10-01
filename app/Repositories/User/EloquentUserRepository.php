<?php
declare(strict_types = 1);

namespace App\Repositories\User;

use App\Models\Role\RoleInterface;
use App\Models\User\EloquentUser;
use App\Models\User\UserInterface;
use Cartalyst\Sentinel\Hashing\HasherInterface;
use Cartalyst\Sentinel\Users\IlluminateUserRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class EloquentUserRepository extends IlluminateUserRepository implements UserRepositoryInterface
{
    public function __construct(HasherInterface $hasher, Dispatcher $dispatcher = null, $model = null)
    {
        parent::__construct($hasher, $dispatcher, EloquentUser::class);
    }

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
                    $query->select(array_merge($rolesColumns));
                },
                'activations' => function ($query) use ($activationsColumns) {
                    /** @var Builder $query */
                    $query->select(array_merge($activationsColumns, ['user_id']));
                },
                'ban' => function ($query) use ($banColumns) {
                    /** @var Builder $query */
                    $query->select(array_merge($banColumns, ['user_id']));
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

    public function hasRole(UserInterface $user, RoleInterface $role): bool
    {
        return DB::table('role_users')
            ->where('user_id', $user->getId())
            ->where('role_id', $role->getId())
            ->exists();
    }

    public function delete(int $id): bool
    {
        return (bool)EloquentUser::where('id', $id)->delete();
    }

    public function deleteByUsername(string $username): bool
    {
        return (bool)EloquentUser::where('username', $username)->delete();
    }
}
