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
