<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => null,
        'secret' => null,
    ],

    'ses' => [
        'key' => null,
        'secret' => null,
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => null,
    ],

    'stripe' => [
        'model' => \App\Models\User\EloquentUser::class,
        'key' => null,
        'secret' => null,
    ],

];
