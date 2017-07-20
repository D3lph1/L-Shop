<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property string $player
 * @property string $type
 * @property string $item
 * @property int $amount
 * @property string $extra
 * @property int $item_id
 * @property \Carbon\Carbon $created_at
 * @property int $server
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereExtra($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereItem($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart wherePlayer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereServer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereType($value)
 */
class Cart extends Model
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
}
