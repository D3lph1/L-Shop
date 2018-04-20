<?php

return [
    'payers' => [
        // Builtin payers...
        \App\Services\Purchasing\Payers\RobokassaPayer::class,
        \App\Services\Purchasing\Payers\InterkassaPayer::class,

        // Custom payers...
    ],
    'distributors' => [
        \App\Services\Purchasing\Distributors\ShoppingCartDistributor::class
    ]
];
