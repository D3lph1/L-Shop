<?php
declare(strict_types = 1);

namespace App\Models\Activation;

use Carbon\Carbon;
use Cartalyst\Sentinel\Activations\EloquentActivation as BaseActivation;

/**
 * App\Models\Activation\EloquentActivation
 *
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property bool $completed
 * @property \Carbon\Carbon|null $completed_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activation\EloquentActivation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activation\EloquentActivation whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activation\EloquentActivation whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activation\EloquentActivation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activation\EloquentActivation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activation\EloquentActivation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activation\EloquentActivation whereUserId($value)
 * @mixin \Eloquent
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 */
class EloquentActivation extends BaseActivation implements ActivationInterface
{
    protected $dates = ['completed_at'];

    public function getCompletedAt(): ?Carbon
    {
        return $this->completed_at;
    }
}
