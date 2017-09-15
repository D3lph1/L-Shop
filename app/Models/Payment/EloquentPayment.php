<?php
declare(strict_types = 1);

namespace App\Models\Payment;

use App\Models\User\EloquentUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property-read \App\Models\User $user
 */
class EloquentPayment extends Model implements PaymentInterface
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'user_id', 'id');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getProducts(): array
    {
        return json_decode($this->products, true);
    }

    public function getCost(): float
    {
        return $this->cost;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getServerId(): int
    {
        return $this->server_id;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
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
