<?php
declare(strict_types = 1);

namespace App\Models\User;

use App\Models\Activation\EloquentActivation;
use App\Models\Ban\EloquentBan;
use App\Models\News\EloquentNews;
use App\Models\Payment\EloquentPayment;
use App\Models\Persistence\EloquentPersistence;
use App\Models\Reminder\EloquentReminder;
use App\Models\Role\EloquentRole;
use App\Services\User\Permissions;
use App\Services\User\Roles;
use Cartalyst\Sentinel\Users\EloquentUser as BaseUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\User\EloquentUser
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property array $permissions
 * @property string|null $last_login
 * @property float $balance
 * @property string|null $uuid
 * @property string|null $accessToken
 * @property string|null $serverID
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activation\EloquentActivation[] $activations
 * @property-read \App\Models\Ban\EloquentBan $ban
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\News\EloquentNews[] $news
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment\EloquentPayment[] $payments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Persistence\EloquentPersistence[] $persistences
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Sentinel\Reminders\EloquentReminder[] $reminders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role\EloquentRole[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Sentinel\Throttling\EloquentThrottle[] $throttle
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\EloquentUser whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\EloquentUser whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\EloquentUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\EloquentUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\EloquentUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\EloquentUser whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\EloquentUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\EloquentUser wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\EloquentUser whereServerID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\EloquentUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\EloquentUser whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\EloquentUser whereUuid($value)
 * @mixin \Eloquent
 * @author D3lph1 <d3lph1.contact@gmail.com>
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
        'username'
    ];

    protected static $activationsModel = EloquentActivation::class;

    protected static $rolesModel = EloquentRole::class;

    protected static $persistencesModel = EloquentPersistence::class;

    protected static $remindersModel = EloquentReminder::class;

    private $rolesManager = null;

    private $permissionsManager = null;

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

    public function getRoles(): iterable
    {
        return $this->roles;
    }

    public function getRolesManager(): Roles
    {
        if (is_null($this->rolesManager)) {
            $this->rolesManager = new Roles($this);
        }

        return $this->rolesManager;
    }

    public function getPermissionsManager(): Permissions\Permissions
    {
        if (is_null($this->permissionsManager)) {
            $this->permissionsManager = new Permissions\UserPermissions($this);
        }

        return $this->permissionsManager;
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

    public function getPermissions(): ?array
    {
        return $this->permissions;
    }
}
