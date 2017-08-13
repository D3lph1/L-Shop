<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ban
 *
 * @property int $id
 * @property int $user_id
 * @property \Carbon\Carbon $until
 * @property string $reason
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ban whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ban whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ban whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ban whereUntil($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ban whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ban whereUserId($value)
 * @mixin \Eloquent
 */
class Ban extends Model
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return \Carbon\Carbon|null
     */
    public function getUntil()
    {
        return $this->until;
    }

    /**
     * @return string|null
     */
    public function getReason()
    {
        return $this->reason;
    }
}
