<?php
declare(strict_types = 1);

namespace App\Models\Product;

use App\Models\Category\CategoryInterface;
use App\Models\Category\EloquentCategory;
use App\Models\Item\EloquentItem;
use App\Models\Item\ItemInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Product
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models
 * @property-read ItemInterface $item_
 * @mixin \Eloquent
 * @property int $id
 * @property int $price
 * @property int $item_id
 * @property int $server_id
 * @property int $stack
 * @property int $category_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Product whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Product wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Product whereServerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Product whereStack($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Product whereUpdatedAt($value)
 * @property float $sort_priority
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Product whereSortPriority($value)
 */
class EloquentProduct extends Model implements ProductInterface
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

    public function item_(): HasOne
    {
        return $this->hasOne(EloquentItem::class, 'id', 'item_id');
    }

    public function category(): HasOne
    {
        return $this->hasOne(EloquentCategory::class, 'id', 'category_id');
    }

    public function getItem(): ItemInterface
    {
        return $this->item_;
    }

    public function getCategory(): CategoryInterface
    {
        return $this->category;
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

    public function getSortPriority(): float
    {
        return $this->sort_priority;
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
