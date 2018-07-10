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
        'security' => [
            'captcha' => [
                'enabled' => false,
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
                'ttl' => 3
            ]
        ],
        'news' => [
            'enabled' => true,
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
            'enabled' => true,
            'send_activation' => true,
            'custom_redirect' => [
                'enabled' => false,
                'url' => ''
            ]
        ],
        'reset_password' => [
            'enabled' => true
        ],
        'change_password' => [
            'enabled' => true
        ]
    ],
    'purchasing' => [
        'min_fill_balance_sum' => 3,
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
                'checkout_id' => '',
                'key' => '',
                'test_key' => '',
                'currency' => '',
                'algorithm' => 'sha256',
                'test' => true
            ]
        ]
    ],
    'api' => [
        'enabled' => false,
        'key' => str_random(32),
        'delimiter' => ':',
        'algorithm' => 'sha256',
        'login_enabled' => false,
        'register_enabled' => false,
        'auth' => [
            'sashok724sV3Launcher' => [
                'enabled' => true,
                'format' => 'OK:{username}',
                'ips' => []
            ]
        ]
    ]
];
