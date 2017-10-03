<?php
declare(strict_types = 1);

namespace App\Models\Persistence;

use Cartalyst\Sentinel\Persistences\EloquentPersistence as BasePersistence;

/**
 * App\Models\Persistence\EloquentPersistence
 *
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User\EloquentUser $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Persistence\EloquentPersistence whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Persistence\EloquentPersistence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Persistence\EloquentPersistence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Persistence\EloquentPersistence whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Persistence\EloquentPersistence whereUserId($value)
 * @mixin \Eloquent
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */
class EloquentPersistence extends BasePersistence implements PersistenceInterface
{
    //
}
