<?php
declare(strict_types = 1);

namespace App\Models\Server;

use App\Models\Category\EloquentCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Server
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property bool $enabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Server whereEnabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Server whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Server whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Server whereUpdatedAt($value)
 * @property string $ip
 * @property int $port
 * @property bool $monitoring_enabled
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Server whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Server whereMonitoringEnabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Server wherePort($value)
 * @property string $password
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Server wherePassword($value)
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
