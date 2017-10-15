<?php
declare(strict_types = 1);

namespace App\Models\Item;

use App\Models\Product\EloquentProduct;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Item\EloquentItem
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property string $item
 * @property string|null $image
 * @property string|null $extra
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product\EloquentProduct[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item\EloquentItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item\EloquentItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item\EloquentItem whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item\EloquentItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item\EloquentItem whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item\EloquentItem whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item\EloquentItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item\EloquentItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item\EloquentItem whereUpdatedAt($value)
 * @mixin \Eloquent
 * @author D3lph1 <d3lph1.contact@gmail.com>
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

    public function setId(int $id): ItemInterface
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): ItemInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(?string $description): ItemInterface
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setType(string $type): ItemInterface
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setItem(string $item): ItemInterface
    {
        $this->item = $item;

        return $this;
    }

    public function getItem(): string
    {
        return $this->item;
    }

    public function setImage(?string $image): ItemInterface
    {
        $this->image = $image;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setExtra(?string $extra): ItemInterface
    {
        $this->extra = $extra;

        return $this;
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
