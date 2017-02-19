<?php

namespace App\Contracts;

use App\Models\Payment;

/**
 * Interface Distributor
 * This interface must implement all of the classes, the issue of producing goods player
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Contracts
 */
interface Distributor
{
    public function give(Payment $payment);
}
