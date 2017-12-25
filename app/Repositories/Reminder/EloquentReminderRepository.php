<?php
declare(strict_types = 1);

namespace App\Repositories\Reminder;

use App\Models\Reminder\EloquentReminder;
use Cartalyst\Sentinel\Reminders\IlluminateReminderRepository;

/**
 * Class EloquentReminderRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Reminder
 */
class EloquentReminderRepository extends IlluminateReminderRepository implements ReminderRepositoryInterface
{
    public function deleteByUser(int $userId): bool
    {
        return (bool)EloquentReminder::where('user_id', $userId)->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function truncate(): void
    {
        EloquentReminder::truncate();
    }
}
