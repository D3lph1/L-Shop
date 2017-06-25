<?php

namespace App\Repositories;

use App\Models\Ban;
use Cartalyst\Sentinel\Users\UserInterface;

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
}
