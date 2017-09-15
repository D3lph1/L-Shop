<?php
declare(strict_types = 1);

namespace App\Repositories\User;

use App\Models\User\EloquentUser;
use Illuminate\Database\Eloquent\Builder;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function search(string $search, array $searchSpecials): array
    {
        /** @var Builder $builder */
        $builder = EloquentUser::select(['id', 'username', 'email', 'balance']);

        $first = $search[0];
        if (in_array($first, $searchSpecials)) {
            $result = $builder
                ->where('balance', $first, str_replace($first, '', $search))
                ->get();
        } else {
            $pattern = '%' . $search . '%';
            $result = $builder
                ->where('id', 'like', $pattern)
                ->orWhere('username', 'like', $pattern)
                ->orWhere('email', 'like', $pattern)
                ->orWhere('balance', 'like', $pattern)
                ->get();
        }

        return $result->toArray();
    }
}
