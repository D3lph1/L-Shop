<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Monitoring driver
    |--------------------------------------------------------------------------
    |
    | The monitoring driver is a class that contains the logic for obtaining
    | server state data. It must necessarily implement the interface
    | App\Services\Monitoring\Drivers\Driver.
    |
    */

    'driver' => \App\Services\Monitoring\Drivers\RconDriver::class
];
