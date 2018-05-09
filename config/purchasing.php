<?php

return [
    'payers' => [
        // Builtin payers...
        \App\Services\Purchasing\Payers\RobokassaPayer::class,
        \App\Services\Purchasing\Payers\InterkassaPayer::class,

        // Custom payers...
    ],
    'distribution' => [
        'distributors' => [
            \App\Services\Purchasing\Distributors\ShoppingCartDistributor::class,
            \App\Services\Purchasing\Distributors\RconDistributor::class
        ],
        'rcon' => [
            // Connection timeout (in seconds).
            'timeout' => 1,
            'commands' => [
                'give_non_enchanted_item' => 'give {player} {item} {amount} 0 {tags}',
                'give_enchanted_item' => 'give {player} {item} {amount} 0 {tags}',
                'give_non_expired_permgroup' => 'pex user {player} group add {permgroup} *',
                'give_expired_permgroup' => 'pex user {player} group add {permgroup} * {lifetime}'
            ],
            'success_response' => '#Given \[.+\] \* \d+ to .*#ui',
            'extra' => [
                'before' => [],
                'after' => []
            ]
        ]
    ]
];
