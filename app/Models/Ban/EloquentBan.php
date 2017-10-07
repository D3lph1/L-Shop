<?php
declare(strict_types=1);

namespace App\Models\Ban;

use App\Models\User\EloquentUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Ban\EloquentBan
 *
 * @property int                                $id
 * @property int                                $user_id
 * @property \Carbon\Carbon|null                $until
 * @property string|null                        $reason
 * @property \Carbon\Carbon|null                $created_at
 * @property \Carbon\Carbon|null                $updated_at
 * @property-read \App\Models\User\EloquentUser $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ban\EloquentBan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ban\EloquentBan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ban\EloquentBan whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ban\EloquentBan whereUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ban\EloquentBan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ban\EloquentBan whereUserId($value)
 * @mixin \Eloquent
 * @author D3lph1 <d3lph1.contact@gmail.com>
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

    public function setUserId(int $id): BanInterface
    {
        $this->id = $id;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUntil(Carbon $until): BanInterface
    {
        $this->until = $until;

        return $this;
    }

    public function getUntil(): ?Carbon
    {
        return $this->until;
    }

    public function setReason(string $reason): BanInterface
    {
        $this->reason = $reason;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }
}
