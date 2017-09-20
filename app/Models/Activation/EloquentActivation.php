<?php
declare(strict_types = 1);

namespace App\Models\Activation;

use Carbon\Carbon;
use Cartalyst\Sentinel\Activations\EloquentActivation as BaseActivation;

class EloquentActivation extends BaseActivation implements ActivationInterface
{
    protected $dates = ['completed_at'];

    public function getCompletedAt(): ?Carbon
    {
        return $this->completed_at;
    }
}
