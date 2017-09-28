<?php
declare(strict_types = 1);

namespace App\Models\Activation;

use Carbon\Carbon;
use Cartalyst\Sentinel\Activations\ActivationInterface as BaseActivationInterface;

/**
 * Interface ActivationInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Activation
 */
interface ActivationInterface extends BaseActivationInterface
{
    public function getCompletedAt(): ?Carbon;
}
