<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Name of cookie with session persistence code.
    |--------------------------------------------------------------------------
    |
    | This cookie stores persistence session code which is required to identify
    | the authenticated user.
    |
    */

    'cookie' => 'l_shop_auth',

    /*
    |--------------------------------------------------------------------------
    | List of active checkpoints.
    |--------------------------------------------------------------------------
    |
    | The array contains a set of checkpoint classes that will be used by the
    | auth system.
    |
    */

    'checkpoints' => [
        \App\Services\Auth\Checkpoint\ActivationCheckpoint::class,
        \App\Services\Auth\Checkpoint\BanCheckpoint::class,
        \App\Services\Auth\Checkpoint\ThrottleCheckpoint::class
    ],

    'validation' => [
        'username' => [

            /*
            |--------------------------------------------------------------------------
            | Username minimum length
            |--------------------------------------------------------------------------
            |
            | The minimum length specified here will be used when validating
            | the user-entered username.
            |
            */

            'min' => 4,

            /*
            |--------------------------------------------------------------------------
            | Username maximum length
            |--------------------------------------------------------------------------
            |
            | The maximum length specified here will be used when validating
            | the user-entered username.
            |
            */

            'max' => 32,

            /**
            |--------------------------------------------------------------------------
            | Username validation rule
            |--------------------------------------------------------------------------
            |
            | Recommend use: "alpha_strict", "alpha_dash_strict", "alpha_num_strict"
            | or define custom in .
            |
            * @see \App\Providers\ValidationServiceProvider::boot()
            |
            */

            'rule' => 'alpha_dash_strict'
        ],

        'password' => [

            /*
            |--------------------------------------------------------------------------
            | Password minimal length
            |--------------------------------------------------------------------------
            |
            | The maximum length specified here will be used when validating
            | the user-entered password. It is not recommended to set the
            | length below 5 for the security of users accounts.
            |
            */
            'min' => 5,

            /*
            |--------------------------------------------------------------------------
            | Password maximum length
            |--------------------------------------------------------------------------
            |
            | The maximum length specified here will be used when validating
            | the user-entered password.
            |
            */

            'max' => 32
        ]
    ],

    'persistence' => [

        /*
        |--------------------------------------------------------------------------
        | Persistence code lifetime
        |--------------------------------------------------------------------------
        |
        | The time (in minutes) after which the session persistence code will
        | become invalid and the user will be logged out.
        |
        */

        'lifetime' => 43800 // 1 month
    ],
    'activation' => [

        /*
        |--------------------------------------------------------------------------
        | Activation code lifetime
        |--------------------------------------------------------------------------
        |
        | The time (in minutes) after which the account activation code will become
        | invalid.
        |
        */

        'lifetime' => 720 // 12 hours
    ],
    'reminder' => [

        /*
        |--------------------------------------------------------------------------
        | Password reminder code lifetime
        |--------------------------------------------------------------------------
        |
        | The time (in minutes) after which the password remind code will become
        | invalid.
        |
        */

        'lifetime' => 720, // 12 hours
    ],

    /*
    |--------------------------------------------------------------------------
    | Application authentication throttling options.
    |--------------------------------------------------------------------------
    |
    | This function is used to protect against account corruption. If you use the
    | allowed number of login attempts, the account, ip-address or the whole
    | application will be frozen for authentication.
    |
    | Set number of attempts 0 to disable throttling section.
    |
    */

    'throttling' => [
        'global' => [
            // [!] Global throttling control disabled by default.

            // The number of login attempts after which there is a lockout.
            'attempts' => 0,
            // Global throttling cooldown (in seconds).
            'cooldown' => 0
        ],
        'ip' => [
            // The number of login attempts after which there is a lockout for this IP-address.
            'attempts' => 5,
            // Ip throttling cooldown (in seconds).
            'cooldown' => 500
        ],
        'user' => [
            // The number of login attempts after which there is a lockout for this user.
            'attempts' => 5,
            // User throttling cooldown (in seconds).
            'cooldown' => 500
        ]
    ],
    'role' => [

        /*
        |--------------------------------------------------------------------------
        | Default roles
        |--------------------------------------------------------------------------
        |
        | These roles will be attached to users when they create a registration.
        |
        */

        'default' => [
            \App\Services\Auth\Roles::USER
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Password hasher class.
    |--------------------------------------------------------------------------
    |
    | The class specified here is responsible for hashing passwords. He must
    | implement the App\Services\Auth\Hashing\Hasher interface.
    | Builtin hashers:
    | - App\Services\Auth\Hashing\BcryptHasher (Recommended)
    | - App\Services\Auth\Hashing\CallbackHasher
    | - App\Services\Auth\Hashing\Sha256Hasher
    | - App\Services\Auth\Hashing\Sha512Hasher
    | - App\Services\Auth\Hashing\WhirlpoolHasher
    |
    */

    'hasher' => \App\Services\Auth\Hashing\BcryptHasher::class
];
