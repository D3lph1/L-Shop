<?php
declare(strict_types = 1);

namespace App\Models\Cart;

use App\Models\Item\EloquentItem;
use App\Models\Item\ItemInterface;
use App\Models\User\EloquentUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Cart\EloquentCart
 *
 * @property int $id
 * @property int $server
 * @property string $player
 * @property string $type
 * @property string $item
 * @property int $amount
 * @property string|null $extra
 * @property int $item_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Item\EloquentItem $item_
 * @property-read \App\Models\User\EloquentUser $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart\EloquentCart whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart\EloquentCart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart\EloquentCart whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart\EloquentCart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart\EloquentCart whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart\EloquentCart whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart\EloquentCart wherePlayer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart\EloquentCart whereServer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart\EloquentCart whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart\EloquentCart whereUpdatedAt($value)
 * @mixin \Eloquent
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */
class EloquentCart extends Model implements CartInterface
{
    /**
     * @var string
     */
    protected $table = 'cart';

    /**
     * @var array
     */
    protected $fillable = [
        'player',
        'type',
        'item',
        'amount',
        'extra',
        'item_id',
        'server'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(EloquentUser::class, 'username', 'player');
    }

    public function item_(): HasOne
    {
        return $this->hasOne(EloquentItem::class, 'id', 'item_id');
    }

    public function getRelatedItem(): ItemInterface
    {
        return $this->item_;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getServerId(): int
    {
        return $this->server;
    }

    public function getPlayer(): string
    {
        return $this->player;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getItem(): string
    {
        return $this->item;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getExtra(): ?string
    {
        return $this->extra;
    }

    public function getItemId(): int
    {
        return $this->item_id;
    }

    public function getServer(): int
    {
        return $this->server;
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
