<?php
declare(strict_types = 1);

namespace App\Repositories\Activation;

use App\Models\Activation\EloquentActivation;
use Cartalyst\Sentinel\Activations\IlluminateActivationRepository;

/**
 * Class EloquentActivationRepository
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Activation
 */
class EloquentActivationRepository extends IlluminateActivationRepository implements ActivationRepositoryInterface
{
    public function truncate(): void
    {
        EloquentActivation::truncate();
    }
}
