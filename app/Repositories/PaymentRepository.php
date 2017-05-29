<?php

namespace App\Repositories;

use App\Models\Payment;

/**
 * Class PaymentRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Repositories
 */
class PaymentRepository extends BaseRepository
{
    const MODEL = 'App\Models\Payment';

    /**
     * Receives completed payments created within one year from this moment
     *
     * @param string|array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function forTheLastYearCompleted($columns)
    {
        $columns = $this->prepareColumns($columns);

        return \Cache::get('admin.statistic.for_the_last_year_completed', function () use ($columns) {
            $result = Payment::select($columns)
                ->where('updated_at', '>', '(NOW() - INTERVAL 1 YEAR)')
                ->where('completed', 1)
                ->orderBy('updated_at', 'ASC')
                ->get();

            \Cache::put('admin.statistic.for_the_last_year_completed', $result, s_get('caching.statistic.ttl', 60));

            return $result;
        });
    }

    /**
     * Summarizes the income received from the sale of products for all time
     *
     * @return int
     */
    public function profit()
    {
        return \Cache::get('admin.statistic.profit', function () {
            $result = Payment::where('completed', 1)
                ->where(function ($query) {
                    $query->where('username', null)
                        ->orWhere(function ($query) {
                            $query->whereNotNull('username')
                                ->where('products', null);
                        });
                })
                ->sum('cost');

            \Cache::put('admin.statistic.profit', $result, s_get('caching.statistic.ttl', 60));

            return $result;
        });
    }

    /**
     * Complete given payment
     *
     * @param int    $id
     * @param string $serviceName
     *
     * @return bool
     */
    public function complete($id, $serviceName)
    {
        return Payment::where('id', $id)
            ->update([
                'service' => $serviceName,
                'completed' => true
            ]);
    }

    /**
     * Get payments history for user with given id
     *
     * @param int   $userId
     * @param array $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function historyForUser($userId, array $columns = [])
    {
        $columns = $this->prepareColumns($columns);

        return Payment::select()
            ->where('payments.user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->paginate(s_get('profile.payments_per_page', 10));
    }

    /**
     * Get payments history paginated
     *
     * @param array $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function allHistory(array $columns = [])
    {
        $columns = $this->prepareColumns($columns);

        return Payment::select($columns)
            ->orderBy('created_at', 'DESC')
            ->paginate(50);
    }
}
