<?php
declare(strict_types = 1);

namespace App\Repositories\User;

use App\Models\Role\RoleInterface;
use App\Models\User\EloquentUser;
use App\Models\User\UserInterface;
use App\Repositories\Activation\ActivationRepositoryInterface;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Repositories\Persistence\PersistenceRepositoryInterface;
use App\Repositories\Reminder\ReminderRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Traits\ContainerTrait;
use Cartalyst\Sentinel\Hashing\HasherInterface;
use Cartalyst\Sentinel\Users\IlluminateUserRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentUserRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\User
 */
class EloquentUserRepository extends IlluminateUserRepository implements UserRepositoryInterface
{
    use ContainerTrait;

    public function findByUsername(string $username, array $columns): ?UserInterface
    {
        return EloquentUser::select($columns)->where('username', $username)->first();
    }

    public function findByEmail(string $email, array $columns): ?UserInterface
    {
        return EloquentUser::select($columns)->where('email', $email)->first();
    }

    public function updatePermissions(int $id, array $permissions): bool
    {
        return (bool)EloquentUser::where('id', $id)->update([
            'permissions' => count($permissions) === 0 ? null : json_encode($permissions)
        ]);
    }

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

    public function incrementById(int $id, string $column, float $incValue = 1): void
    {
        EloquentUser::where('id', $id)->increment($column, $incValue);
    }

    public function delete(int $id): bool
    {
        $this->deleteRelated($id);

        return (bool)EloquentUser::where('id', $id)->delete();
    }

    public function deleteByUsername(string $username): bool
    {
        $user = $this->findByUsername($username, ['id']);

        if (is_null($user)) {
            return false;
        }

        $this->deleteRelated($user->getId());

        return (bool)EloquentUser::where('username', $username)->delete();
    }

    protected function deleteRelated(int $userId)
    {
        /** @var ActivationRepositoryInterface $activationRepository */
        $activationRepository = $this->make(ActivationRepositoryInterface::class);
        $activationRepository->deleteByUser($userId);

        /** @var PersistenceRepositoryInterface $persistenceRepository */
        $persistenceRepository = $this->make(PersistenceRepositoryInterface::class);
        $persistenceRepository->deleteByUser($userId);

        /** @var ReminderRepositoryInterface $reminderRepository */
        $reminderRepository = $this->make(ReminderRepositoryInterface::class);
        $reminderRepository->deleteByUser($userId);

        /** @var RoleRepositoryInterface $roleRepository */
        $roleRepository = $this->make(RoleRepositoryInterface::class);
        $roleRepository->detachAllUser($userId);

        /** @var PaymentRepositoryInterface $paymentRepository */
        $paymentRepository = $this->make(PaymentRepositoryInterface::class);
        $paymentRepository->deleteByUserId($userId);
    }
}
