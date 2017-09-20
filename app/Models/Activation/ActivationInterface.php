<?php
declare(strict_types = 1);

namespace App\Models\Activation;

use Carbon\Carbon;
use Cartalyst\Sentinel\Activations\ActivationInterface as BaseActivationInterface;

interface ActivationInterface extends BaseActivationInterface
{
    public function getCompletedAt(): ?Carbon;
}
