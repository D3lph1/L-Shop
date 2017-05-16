<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property string $service
 * @property string $products
 * @property float $cost
 * @property int $user_id
 * @property string $username
 * @property int $server_id
 * @property string $ip
 * @property bool $completed
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereCompleted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereCost($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereProducts($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereServerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereService($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereUsername($value)
 */
class Payment extends Model
{
    /**
     * @var string
     */
    protected $table = 'payments';

    /**
     * @var array
     */
    protected $fillable = [
        'service',
        'products',
        'cost',
        'user_id',
        'username',
        'server_id',
        'ip',
        'completed',
        'created_at',
        'updated_at'
    ];
}
