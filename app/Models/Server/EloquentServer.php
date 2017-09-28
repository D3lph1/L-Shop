<?php
declare(strict_types = 1);

namespace App\Models\Server;

use App\Models\Category\EloquentCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Server\EloquentServer
 *
 * @property int $id
 * @property string $name
 * @property int $enabled
 * @property string|null $ip
 * @property int|null $port
 * @property string|null $password
 * @property int $monitoring_enabled
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category\EloquentCategory[] $categories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\EloquentServer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\EloquentServer whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\EloquentServer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\EloquentServer whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\EloquentServer whereMonitoringEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\EloquentServer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\EloquentServer wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\EloquentServer wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\EloquentServer whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 */
class EloquentServer extends Model implements ServerInterface
{
    /**
     * @var string
     */
    protected $table = 'servers';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'enabled',
        'ip',
        'port',
        'password',
        'monitoring_enabled'
    ];

    /**
     * Get categories that are tied to the server.
     */
    public function categories(): HasMany
    {
        return $this->hasMany(EloquentCategory::class, 'server_id', 'id');
    }

    public function getCategories(): iterable
    {
        return $this->categories;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function isEnabled(): bool
    {
        return (bool)$this->enabled;
    }

    public function isMonitoringEnabled(): bool
    {
        return (bool)$this->monitoring_enabled;
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
