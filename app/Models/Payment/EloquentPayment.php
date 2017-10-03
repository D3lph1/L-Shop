<?php
declare(strict_types = 1);

namespace App\Models\Payment;

use App\Models\User\EloquentUser;
use App\Models\User\UserInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Payment\EloquentPayment
 *
 * @property int $id
 * @property string|null $service
 * @property string|null $products
 * @property float|null $cost
 * @property int|null $user_id
 * @property string|null $username
 * @property int|null $server_id
 * @property string $ip
 * @property int $completed
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User\EloquentUser|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\EloquentPayment whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\EloquentPayment whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\EloquentPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\EloquentPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\EloquentPayment whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\EloquentPayment whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\EloquentPayment whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\EloquentPayment whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\EloquentPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\EloquentPayment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\EloquentPayment whereUsername($value)
 * @mixin \Eloquent
 * @author D3lph1 <d3lph1.contact@gmail.com>
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

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function getProducts(): ?array
    {
        return is_null($this->products) ? null : json_decode($this->products, true);
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
        return (bool)$this->completed;
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
