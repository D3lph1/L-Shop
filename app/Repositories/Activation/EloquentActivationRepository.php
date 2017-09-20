<?php
declare(strict_types = 1);

namespace App\Repositories\Activation;

use App\Models\Activation\EloquentActivation;
use Cartalyst\Sentinel\Activations\IlluminateActivationRepository;

class EloquentActivationRepository extends IlluminateActivationRepository implements ActivationRepositoryInterface
{
    public function truncate(): void
    {
        EloquentActivation::truncate();
    }
}
