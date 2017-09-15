<?php
declare(strict_types = 1);

namespace App\Models\Ban;

use App\Models\User\EloquentUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Ban
 *
 * @property int $id
 * @property int $user_id
 * @property Carbon $until
 * @property string $reason
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ban whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ban whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ban whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ban whereUntil($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ban whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ban whereUserId($value)
 * @mixin \Eloquent
 */
class EloquentBan extends Model implements BanInterface
{
    /**
     * @var string
     */
    protected $table = 'bans';

    protected $fillable = [
        'user_id',
        'until',
        'reason'
    ];

    protected $dates = [
        'until',
        'created_at',
        'updated_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'user_id', 'id');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getUntil(): ?Carbon
    {
        return $this->until;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }
}
