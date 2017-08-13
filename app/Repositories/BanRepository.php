<?php

namespace App\Repositories;

use App\Models\Ban;
use Carbon\Carbon;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BanRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Repositories
 */
class BanRepository extends BaseRepository
{
    const MODEL = Ban::class;

    /**
     * @param UserInterface $user
     *
     * @return Ban
     */
    public function findByUser(UserInterface $user)
    {
        return $this
            ->query()
            ->where('user_id', $user->getUserId())
            ->first();
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function deleteByUser(UserInterface $user)
    {
        return $this
            ->query()
            ->where('user_id', $user->getUserId())
            ->delete();
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function isBanned(UserInterface $user)
    {
        return (bool)$this
            ->query()
            ->where(function ($b) {
                /** @var Builder $b */
                $b
                    ->where('until', '>=', Carbon::now()->toDateTimeString())
                    ->orWhere('until', null);
            })
            ->where('user_id', $user->getUserId())
            ->count();
    }
}
