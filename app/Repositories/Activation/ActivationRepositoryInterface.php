<?php
declare(strict_types = 1);

namespace App\Repositories\Activation;

use App\Repositories\BaseRepositoryInterface;
use Cartalyst\Sentinel\Activations\ActivationRepositoryInterface as BaseActivationRepositoryInterface;

/**
 * Interface ActivationRepositoryInterface
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Activation
 */
interface ActivationRepositoryInterface extends BaseActivationRepositoryInterface, BaseRepositoryInterface
{
    public function deleteByUser(int $userId): bool;
}
