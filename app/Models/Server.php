<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
 * @property int $password
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Server wherePassword($value)
 */
class Server extends Model
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(Category::class, 'server_id', 'id');
    }
}
