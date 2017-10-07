<?php
declare(strict_types = 1);

namespace App\Models\Category;

use App\Models\Server\EloquentServer;
use App\Models\Server\ServerInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Category\EloquentCategory
 *
 * @property int $id
 * @property string $name
 * @property int $server_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Server\EloquentServer $server
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\EloquentCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\EloquentCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\EloquentCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\EloquentCategory whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\EloquentCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */
class EloquentCategory extends Model implements CategoryInterface
{
    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'server_id'
    ];

    /**
     * Get the server to which the category is bound.
     */
    public function server(): HasOne
    {
        return $this->hasOne(EloquentServer::class, 'id', 'server_id');
    }

    public function getServer(): ServerInterface
    {
        return $this->server;
    }

    public function setId(int $id): CategoryInterface
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): CategoryInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setServerId(int $id): CategoryInterface
    {
        $this->server_id = $id;

        return $this;
    }

    public function getServerId(): int
    {
        return $this->server_id;
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
