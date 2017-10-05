<?php
declare(strict_types = 1);

namespace App\Models\Role;

use App\Services\User\Permissions\Permissions;
use App\Services\User\Permissions\RolePermissions;
use Cartalyst\Sentinel\Roles\EloquentRole as BaseRole;

/**
 * App\Models\Role\EloquentRole
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property array $permissions
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\EloquentUser[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role\EloquentRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role\EloquentRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role\EloquentRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role\EloquentRole wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role\EloquentRole whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role\EloquentRole whereUpdatedAt($value)
 * @mixin \Eloquent
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */
class EloquentRole extends BaseRole implements RoleInterface
{
    /**
     * @var string
     */
    protected $table = 'roles';

    protected $fillable = [
        'slug',
        'name',
        'permissions'
    ];

    private $permissionsManager = null;

    public function getPermissionsManager(): Permissions
    {
        if (is_null($this->permissionsManager)) {
            $this->permissionsManager = new RolePermissions($this);
        }

        return $this->permissionsManager;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }
}
