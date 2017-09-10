<?php
declare(strict_types = 1);

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

    public function findByUser(UserInterface $user): ?Ban
    {
        return $this
            ->query()
            ->where('user_id', $user->getUserId())
            ->first();
    }

    public function deleteByUser(UserInterface $user): bool
    {
        return $this
            ->query()
            ->where('user_id', $user->getUserId())
            ->delete();
    }

    public function isBanned(UserInterface $user): bool
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
