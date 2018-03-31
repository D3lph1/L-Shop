<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Payments;

interface Checkout
{
    public function validate(array $data): bool;
}
