<?php
declare(strict_types = 1);

namespace App\Repositories\Ban;

use App\Models\Ban\BanInterface;
use App\Models\Ban\EloquentBan;
use Carbon\Carbon;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BanRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories
 */
class EloquentBanRepository implements BanRepositoryInterface
{
    public function create(BanInterface $entity): BanInterface
    {
        return EloquentBan::create([
            'user_id' => $entity->getUserId(),
            'until' => $entity->getUntil(),
            'reason' => $entity->getReason()
        ]);
    }

    public function findByUser(UserInterface $user): ?BanInterface
    {
        return EloquentBan::where('user_id', $user->getUserId())->first();
    }

    public function deleteByUser(UserInterface $user): bool
    {
        return (bool)EloquentBan::where('user_id', $user->getUserId())->delete();
    }

    public function isBanned(UserInterface $user): bool
    {
        return EloquentBan::where(function ($b) {
                /** @var Builder $b */
                $b
                    ->where('until', '>=', Carbon::now()->toDateTimeString())
                    ->orWhere('until', null);
            })
            ->where('user_id', $user->getUserId())
            ->exists();
    }

    /**
     * {@inheritdoc}
     */
    public function truncate(): void
    {
        EloquentBan::truncate();
    }
}
