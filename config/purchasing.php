<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Registered application payers.
    |--------------------------------------------------------------------------
    |
    | The array contains the full names of the classes of payers. All classes listed here
    | in the mandatory order must implement the interface App\Services\Purchasing\Payers\Payer.
    |
    */

    'payers' => [
        // Builtin payers...
        \App\Services\Purchasing\Payers\RobokassaPayer::class,
        \App\Services\Purchasing\Payers\InterkassaPayer::class,

        // Custom payers...
    ],
    'distribution' => [

        /*
        |--------------------------------------------------------------------------
        | Registered application distributors.
        |--------------------------------------------------------------------------
        |
        | The array contains the full names of the classes of distributors. All classes listed here
        | in the mandatory order must implement the interface App\Services\Purchasing\Distributors\Distributor.
        |
        */

        'distributors' => [
            // Builtin distributors...
            \App\Services\Purchasing\Distributors\ShoppingCartDistributor::class,
            \App\Services\Purchasing\Distributors\RconDistributor::class,

            // Custom distributors...
        ],
        'rcon' => [

            /*
            |--------------------------------------------------------------------------
            | Connection timeout.
            |--------------------------------------------------------------------------
            |
            | After the number of seconds specified here, there will be a forced disconnection from
            | the minecraft server, if the connection has not been established.
            |
            */

            'timeout' => 1,
            'commands' => [

                /*
                |--------------------------------------------------------------------------
                | Command to distribute a non enchanted item.
                |--------------------------------------------------------------------------
                |
                | This command will be executed to issue the non enchanted item. In the commands
                | there are placeholders. They will be replaced by the corresponding values ​​in
                | the runtime:
                | - {player} The name of the player who wants to distribute the item.
                | - {item} In-game identifier of the distributed item.
                | - {amount} The amount of the item to be distributed.
                | - {nbt} Nbt tags for this item. Here comes the information from Extra field of the
                | item.
                |
                */

                'give_non_enchanted_item' => 'give {player} {item} {amount} 0 {nbt}',

                /*
                |--------------------------------------------------------------------------
                | Command to distribute an enchanted item.
                |--------------------------------------------------------------------------
                |
                | This command will be executed to issue the enchanted item. In the commands there
                | are placeholders. They will be replaced by the corresponding values ​​in the runtime:
                | - {player} The name of the player who wants to distribute the item.
                | - {item} In-game identifier of the distributed item.
                | - {amount} The amount of the item to be distributed.
                | - {nbt} Nbt tags for this item. If the given item is enchanted, enchantments will
                | be prescribed here. In addition, the information from the Extra field of the item.
                |
                */

                'give_enchanted_item' => 'give {player} {item} {amount} 0 {nbt}',

                /*
                |--------------------------------------------------------------------------
                | Command to distribute a permanent permission group.
                |--------------------------------------------------------------------------
                |
                | This command will be executed to issue the permanent permission group. In the commands
                | there are placeholders. They will be replaced by the corresponding values ​​in the
                | runtime:
                | - {player} The name of the player who wants to distribute the permission group.
                | - {permgroup} In-game identifier of the distributed permission group.
                |
                */

                'give_non_expired_permgroup' => 'pex user {player} group add {permgroup} *',

                /*
                |--------------------------------------------------------------------------
                | Command to distribute a permanent permission group.
                |--------------------------------------------------------------------------
                |
                | This command will be executed to issue the permanent permission group. In the commands
                | there are placeholders. They will be replaced by the corresponding values ​​in the
                | runtime:
                | - {player} The name of the player who wants to distribute the permission group.
                | - {permgroup} In-game identifier of the distributed permission group.
                | - {lifetime} Lifetime of permission group (in seconds).
                |
                */

                'give_expired_permgroup' => 'pex user {player} group add {permgroup} * {lifetime}',

                /*
                |--------------------------------------------------------------------------
                | Command to distribute an in-game currency to player.
                |--------------------------------------------------------------------------
                |
                | This command will be executed to issue the in-game currency to player. In the commands
                | there are placeholders. They will be replaced by the corresponding values ​​in the
                | runtime:
                | - {player} The name of the player whose in-game balance will be refilled.
                | - {amount} The amount of currency that will be credited to the account of the specified
                |            player.
                |
                */

                'give_currency' => 'money grant {player} {amount}',

                /*
                |--------------------------------------------------------------------------
                | Command to distribute an owning of the region.
                |--------------------------------------------------------------------------
                |
                | This command will be executed to empower a player to own a region. In the commands
                | there are placeholders. They will be replaced by the corresponding values ​​in the
                | runtime:
                | - {region} The name of the region to which you want to be granted access.
                | - {player} The name of the player who will be given access to the region.
                |
                */

                'add_region_owner' => 'rg addowner {region} {player}',

                /*
                |--------------------------------------------------------------------------
                | Command to distribute a membership in the region.
                |--------------------------------------------------------------------------
                |
                | This command will be executed to give the player membership in the region. In the commands
                | there are placeholders. They will be replaced by the corresponding values ​​in the
                | runtime:
                | - {region} The name of the region to which you want to be granted access.
                | - {player} The name of the player who will be given access to the region.
                |
                */

                'add_region_member' => 'rg addmember {region} {player}',
            ],

            /*
            |--------------------------------------------------------------------------
            | The patterns of a successful response.
            |--------------------------------------------------------------------------
            |
            | When executing the distribution commands, the system will check the response that came
            | from the server. If it matches this regular expression, then the output will be
            | considered successful. Otherwise, the process will be forced to abort.
            |
            | If the value of the element is null, no mapping is performed.
            |
            */

            'success_response_patterns' => [
                'give_non_enchanted_item' => '#.*#ui',
                'give_enchanted_item' => '#.*#ui',
                'give_non_expired_permgroup' => '#.*#ui',
                'give_expired_permgroup' => '#.*#ui',
                'give_currency' => '#.*#ui',
                'add_region_owner' => '#.*#ui',
                'add_region_member' => '#.*#ui'
            ],
            'extra' => [

                /*
                |--------------------------------------------------------------------------
                | The list of commands performed before the main commands.
                |--------------------------------------------------------------------------
                |
                | The additional commands specified in the array below will be executed before the
                | distribution commands are executed. In the commands there are placeholders.
                | They will be replaced by the corresponding values ​​in the runtime:
                | - {player} The name of the player who purchased the products.
                |
                */

                'before' => [],

                /*
                |--------------------------------------------------------------------------
                | The list of commands performed after the main commands.
                |--------------------------------------------------------------------------
                |
                | The additional commands specified in the array below will be executed after the
                | distribution commands are executed.
                | You can, for example, indicate here the messages about the successful delivery
                | of products.
                | In the commands there are placeholders. They will be replaced by the corresponding
                | values ​​in the runtime:
                | - {player} The name of the player who purchased the products.
                |
                |
                */

                'after' => [
                    // After the successful distributing of products, the player will be notified of this.
                    'tell {player} Purchased items was distributed.'
                ]
            ]
        ]
    ]
];
