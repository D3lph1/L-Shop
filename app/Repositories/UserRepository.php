<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserRepository
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Repositories
 */
class UserRepository extends BaseRepository
{
    const MODEL = 'App\Models\User';

    public function search($search, array $searchSpecials)
    {
        /** @var Builder $builder */
        $builder = User::select(['id', 'username', 'email', 'balance']);

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
