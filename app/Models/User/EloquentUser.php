<?php
declare(strict_types = 1);

namespace App\Models\User;

use App\Models\Activation\EloquentActivation;
use App\Models\Ban\EloquentBan;
use App\Models\News\EloquentNews;
use App\Models\Payment\EloquentPayment;
use Cartalyst\Sentinel\Users\EloquentUser as BaseUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class User
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Sentinel\Activations\EloquentActivation[]    $activations
 * @property array                                                                                                 $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Sentinel\Persistences\EloquentPersistence[]  $persistences
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Sentinel\Reminders\EloquentReminder[] $reminders
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Sentinel\Roles\EloquentRole[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Sentinel\Throttling\EloquentThrottle[] $throttle
 * @mixin \Eloquent
 * @property int                                                                                                   $id
 * @property string                                                                                                $username
 * @property string                                                                                                $email
 * @property string                                                                                                $password
 * @property string                                                                                                $last_login
 * @property float                                                                                                 $balance
 * @property string                                                                                                $uuid
 * @property string                                                                                                $accessToken
 * @property string                                                                                                $serverID
 * @property \Carbon\Carbon                                                                                        $created_at
 * @property \Carbon\Carbon                                                                                        $updated_at
 */
class EloquentUser extends BaseUser implements UserInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'permissions',
        'balance'
    ];

    /**
     * @var array
     */
    protected $loginNames = [
        'username',
        'email'
    ];

    protected static $activationsModel = EloquentActivation::class;

    public function news(): HasMany
    {
        return $this->hasMany(EloquentNews::class, 'user_id', 'id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(EloquentPayment::class, 'user_id', 'id');
    }

    public function ban(): HasOne
    {
        return $this->hasOne(EloquentBan::class, 'user_id', 'id');
    }

    public function getActivations(): iterable
    {
        return $this->activations;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }
}
