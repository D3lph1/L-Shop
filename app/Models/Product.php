<?php
declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models
 * @property-read \App\Models\Item $item
 * @mixin \Eloquent
 * @property int $id
 * @property int $price
 * @property int $item_id
 * @property int $server_id
 * @property int $stack
 * @property int $category_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereServerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereStack($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereUpdatedAt($value)
 * @property float $sort_priority
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereSortPriority($value)
 */
class Product extends Model
{
    protected $fillable = [
        'price',
        'item_id',
        'server_id',
        'stack',
        'category_id'
    ];

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getItemId(): int
    {
        return $this->item_id;
    }

    public function getServerId(): int
    {
        return $this->server_id;
    }

    public function getStack(): float
    {
        return $this->stack;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }
}
