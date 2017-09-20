<?php
declare(strict_types = 1);

namespace App\Services\User\InitStrategies;

use App\Models\User\UserInterface;

interface InitStrategyInterface
{
    public function init(UserInterface $user);
}
