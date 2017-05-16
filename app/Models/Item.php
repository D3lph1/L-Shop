<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property string $item
 * @property string $image
 * @property string $extra
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Item whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Item whereExtra($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Item whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Item whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Item whereItem($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Item whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Item whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Item whereUpdatedAt($value)
 */
class Item extends Model
{
    protected $fillable = ['name', 'description', 'type', 'item', 'image', 'extra'];

    /**
     * @var string
     */
    protected $table = 'items';
}
