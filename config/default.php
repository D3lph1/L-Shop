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
            'enabled' => true,
            'rcon' => [
                'timeout' => 1,
                'command' => 'list',
                'pattern' => '/^.*(?<now>\d+)\/(?<total>\d+).*$/ui',
                'ttl' => 10
            ]
        ],
        'news' => [
            'pagination' => [
                'per_page' => 15
            ]
        ],
        'profile' => [
            'character' => [
                'skin' => [
                    'enabled' => true,
                    'max_file_size' => 768,
                    'list' => json_encode([
                        [64, 32]
                    ]),
                    'hd' => [
                        'enabled' => true,
                        'list' => json_encode([
                            [512, 256],
                            [1024, 512]
                        ])
                    ]
                ],
                'cloak' => [
                    'enabled' => true,
                    'max_file_size' => 512,
                    'list' => json_encode([
                        [22, 17]
                    ]),
                    'hd' => [
                        'enabled' => true,
                        'list' => json_encode([
                            [256, 128],
                            [512, 256]
                        ])
                    ]
                ]
            ]
        ],
        'catalog' => [
            'pagination' => [
                'per_page' => 15,
                'order_by' => 'product.sortPriority',
                'descending' => false
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
    ],
    'purchasing' => [
        'services' => [
            'robokassa' => [
                'enabled' => true,
                'login' => '',
                'payment_password' => '',
                'validation_password' => '',
                'algorithm' => 'sha512',
                'test' => true,
                'culture' => \App\Services\Purchasing\Payments\Robokassa\Checkout::CULTURE_RU
            ],
            'interkassa' => [
                'enabled' => true,
                'login' => '',
                'key' => '',
                'test_key' => '',
                'algorithm' => 'sha256',
                'test' => true
            ]
        ]
    ]
];
