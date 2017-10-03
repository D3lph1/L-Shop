<?php
declare(strict_types = 1);

namespace App\Services\User\InitStrategies;

use App\Models\User\UserInterface;

/**
 * Interface InitStrategyInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\User\InitStrategies
 */
interface InitStrategyInterface
{
    /**
     * Initializes the newly created user.
     */
    public function init(UserInterface $user): void;
}
