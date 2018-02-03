<?php

// Char sequence "$:" indicates the localization key.

return [
    'shop' => [
        'name' => 'L-Shop',
        'description' => '$:shop.description',
        'keywords' => '$:shop.keywords',
        'currency' => [
            'name' => '$:settings.currency.name',
            'html' => '$:settings.currency.html'
        ]
    ],
    'system' => [
        'maintenance' => [
            'enabled' => false
        ],
        'security' => [
            'captcha' => [
                'recaptcha' => [
                    'public_key' => '',
                    'secret_key' => ''
                ]
            ]
        ],
        'monitoring' => [
            'enabled' => true
        ],
        'news' => [
            'first_portion' => 15
        ],
        'profile' => [
            'character' => [
                'skin' => [
                    'enabled' => true
                ],
                'cloak' => [
                    'enabled' => true
                ]
            ]
        ],
        'catalog' => [
            'pagination' => [
                'per_page' => 15
            ]
        ]
    ],
    'auth' => [
        'access_mode' => \App\Services\Auth\AccessMode::ANY,
        'register' => [
            'enabled' => true
        ],
        'reset_password' => [
            'enabled' => true
        ]
    ]
];
