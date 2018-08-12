<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors;

/**
 * Interface Attempting
 * The interface is used to mark distributors that can be called repeatedly. This can be useful
 * if your implementation of the distributor is called repeatedly. For example, if you use the
 * {@see \App\Services\Purchasing\Distributors\RconDistributor}, if you fail to deliver the
 * product, the player may need to manually distribute the product.
 */
interface Attempting
{
    //
}
