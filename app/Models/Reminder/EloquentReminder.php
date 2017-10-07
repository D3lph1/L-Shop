<?php
declare(strict_types = 1);

namespace App\Models\Reminder;

use Carbon\Carbon;
use Cartalyst\Sentinel\Reminders\EloquentReminder as BaseReminder;

/**
 * App\Models\Reminder\EloquentReminder
 *
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property bool $completed
 * @property \Carbon\Carbon|null $completed_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder\EloquentReminder whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder\EloquentReminder whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder\EloquentReminder whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder\EloquentReminder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder\EloquentReminder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder\EloquentReminder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reminder\EloquentReminder whereUserId($value)
 * @mixin \Eloquent
 */
class EloquentReminder extends BaseReminder implements ReminderInterface
{
    /**
     * @var string
     */
    protected $table = 'reminders';

    public function getId(): int
    {
        return $this->id;
    }

    public function setUserId(int $userId): ReminderInterface
    {
        $this->user_id = $userId;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setCode(string $code): ReminderInterface
    {
        $this->code = $code;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCompleted(bool $isCompleted): ReminderInterface
    {
        $this->completed = $isCompleted;

        return $this;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function getCompletedAt(): ?Carbon
    {
        return $this->completed_at;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }
}
