<?php
declare(strict_types = 1);

namespace App\Repositories\Payment;

use App\Models\Payment\EloquentPayment;
use Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class EloquentPaymentRepository implements PaymentRepositoryInterface
{
    /**
     * Receives completed payments created within one year from this moment.
     */
    public function forTheLastYearCompleted(array $columns): iterable
    {
        return Cache::get('admin.statistic.for_the_last_year_completed', function () use ($columns) {
            $result = EloquentPayment::select($columns)
                ->where('updated_at', '>', '(NOW() - INTERVAL 1 YEAR)')
                ->where('completed', 1)
                ->orderBy('updated_at', 'ASC')
                ->get();

            Cache::put('admin.statistic.for_the_last_year_completed', $result, s_get('caching.statistic.ttl', 60));

            return $result;
        });
    }

    public function profit(): float
    {
        return Cache::get('admin.statistic.profit', function () {
            $result = EloquentPayment::where('completed', 1)
                ->where(function ($query) {
                    /** @var $query Builder */
                    $query->where('username', null)
                        ->orWhere(function ($query) {
                            /** @var $query Builder */
                            $query->whereNotNull('username')
                                ->where('products', null);
                        });
                })
                ->sum('cost');

            Cache::put('admin.statistic.profit', $result, s_get('caching.statistic.ttl', 60));

            return $result;
        });
    }

    public function complete(int $id, string $serviceName): bool
    {
        return EloquentPayment::where('id', $id)
            ->update([
                'service' => $serviceName,
                'completed' => true
            ]);
    }

    public function historyForUser(int $userId, array $columns): LengthAwarePaginator
    {
        return EloquentPayment::select($columns)
            ->where('payments.user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->paginate(s_get('profile.payments_per_page', 10));
    }

    public function allHistory(array $columns): LengthAwarePaginator
    {
        return EloquentPayment::select($columns)
            ->orderBy('created_at', 'DESC')
            ->paginate(50);
    }
}
