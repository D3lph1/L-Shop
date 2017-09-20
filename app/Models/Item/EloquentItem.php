<?php
declare(strict_types = 1);

namespace App\Models\Item;

use App\Models\Product\EloquentProduct;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Item whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Item whereExtra($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Item whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Item whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Item whereItem($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Item whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Item whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Repositories\Item whereUpdatedAt($value)
 */
class EloquentItem extends Model implements ItemInterface
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'item',
        'image',
        'extra'
    ];

    /**
     * @var string
     */
    protected $table = 'items';

    /**
     * Get all products tied to the item.
     */
    public function products(): HasMany
    {
        return $this->hasMany(EloquentProduct::class, 'item_id', 'id');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getItem(): string
    {
        return $this->item;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getExtra(): ?string
    {
        return $this->extra;
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
