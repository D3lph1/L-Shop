<?php
declare(strict_types = 1);

namespace App\Models\Category;

use App\Models\Server\EloquentServer;
use App\Models\Server\ServerInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Category
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models
 * @mixin \Eloquent
 * @property int                 $id
 * @property string              $name
 * @property int                 $server_id
 * @property \Carbon\Carbon      $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereServerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereUpdatedAt($value)
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

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
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
