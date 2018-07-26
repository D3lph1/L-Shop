<?php

return [
    'frontend' => [
        'auth' => [
            'login' => [
                'title' => 'Login',
                'maintenance' => 'Login for administration only',
                'login' => 'Login',
                'purchase_without_auth' => 'Purchase without authorization',
                'forgot_password' => 'Forgot password?',
                'logout' => 'Logout'
            ],
            'register' => [
                'title' => 'Signup',
                'btn' => 'Signup'
            ],
            'activation' => [
                'sent' => [
                    'title' => 'Waiting for activation',
                    'short_title' => 'Waiting',
                    'description' => 'A email was sent to the mailbox you specified to confirm registration.
                              <p><p>If the email does not come, you can send it again.</p></p>',
                    'repeat' => 'Отправить повторно'
                ]
            ],
            'password' => [
                'forgot' => [
                    'title' => 'Password reset',
                    'description' => 'We will send a link to your email for password recovery.',
                    'continue' => 'Continue'
                ],
                'reset' => [
                    'title' => 'Reset password',
                    'btn' => 'reset'
                ]
            ],
            'servers' => [
                'title' => 'Select a server'
            ]
        ],
        'shop' => [
            'layout' => [
                'server_not_selected' => 'Not selected'
            ],
            'catalog' => [
                'title' => 'Catalog',
                'categories_does_not_exists' => 'No categories',
                'empty_category' => 'Category is empty',
                'item' => [
                    'enchanted' => 'This item has been enchanted',
                    'hidden' => 'This product is hidden from the catalog',
                    'put_in_cart' => 'Put in cart',
                    'already_in_cart' => 'Already in the cart',
                    'about' => 'Product information',
                    'go_to_product' => 'Go to product',
                    'go_to_item' => 'Go to item',
                    'quick_purchase' => 'Quick purchase',
                    'stack_item' => 'for :stack',
                    'stack_permgroup' => 'for :stack day.',
                    'stack_permgroup_forever' => 'forever',
                    'stack_currency' => 'for :stack',
                    'stack_region_owner' => '',
                    'stack_region_member' => '',
                    'stack_command' => '',
                ],
                'purchase' => [
                    'title' => 'Quick purchase (:product)',
                    'username_description' => 'This user will be issued the purchased products',
                    'amount' => 'Amount:',
                    'duration' => 'Duration:',
                    'cost' => 'Total: :cost :currency',
                    'not_enough' => 'There is not enough money on your account. After clicking the "purchase" button you
                        will be automatically redirected to the payment method selection page.',
                    'not_auth' => 'After clicking the "purchase" button you
                        will be automatically redirected to the payment method selection page.',
                    'purchase' => 'Purchase'
                ],
                'about' => [
                    'title' => 'Product information (:product)',
                    'description' => [
                        'empty' => 'Product description is absent',
                        'title' => 'Product description:'
                    ],
                    'type' => 'Type:',
                    'enchantments' => 'Enchanted:'
                ]
            ],
            'cart' => [
                'title' => 'Cart',
                'empty' => 'Cart is empty',
                'total' => 'Total: :sum :currency',
                'purchase' => 'Purchase',
                'purchase_dialog' => [
                    'title' => 'Purchase formalities'
                ],
                'item' => [
                    'remove' => 'Remove',
                    'cost' => 'Cost: :cost :currency',
                    'forever' => 'This product is purchased forever'
                ]
            ],
            'payment' => [
                'title' => 'Payment for purchase',
                'title_content' => 'Payment of purchase. Select a payment method:',
                'methods_not_available' => 'There are no payment methods available.'
            ],
            'replenishment' => [
                'title' => 'Balance replenishment',
                'sum' => 'Sum of replenishment',
                'btn' => 'Continue'
            ]
        ],
        'profile' => [
            'character' => [
                'title' => 'Character',
                'upload' => 'Upload',
                'skin' => [
                    'image_resolutions' => 'You can upload images of skins with the following permissions: :resolutions.',
                    'file_size' => 'Maximum size of the skin file: :size КБ.'
                ],
                'cloak' => [
                    'not_set' => 'Cloak not installed',
                    'image_resolutions' => 'You can upload images of cloaks with the following permissions: :resolutions.',
                    'file_size' => 'Maximum size of the cloak file: :size КБ.'
                ]
            ],
            'settings' => [
                'title' => 'Settings',
                'password_change' => [
                    'title' => 'Change password',
                    'new' => 'New password',
                    'new_confirmation' => 'Confirm new password'
                ],
                'login_reset' => [
                    'title' => 'Reset of login sessions',
                    'description' => 'After clicking on the button below, all login sessions (including the current one) will be reset. This can be useful in case you want to log out of your account on devices that you do not have access to.',
                    'reset' => 'Reset'
                ]
            ],
            'purchases' => [
                'title' => 'Purchase history',
                'table' => [
                    'headers' => [
                        'id' => 'ID',
                        'cost' => 'Cost',
                        'created_at' => 'Created at',
                        'completed_at' => 'Completed at',
                        'via' => 'Via'
                    ],
                    'type' => [
                        'products' => 'Product purchasing',
                        'refill' => 'Balance replenishment'
                    ],
                    'empty' => 'Purchases list is empty',
                    'details' => 'Details',
                    'pay' => 'Pay',
                    'complete' => 'Complete'
                ],
                'details' => [
                    'title' => 'Products list',
                    'table' => [
                        'headers' => [
                            'name' => 'Name',
                            'image' => 'Image',
                            'stack' => 'For sale by',
                            'amount' => 'Products purchased',
                            'cost' => 'Cost'
                        ]
                    ]
                ],
                'via' => [
                    'by_admin' => 'Completed by administrator'
                ]
            ],
            'cart' => [
                'title' => 'In-game cart',
                'any_server' => 'Any',
                'table' => [
                    'headers' => [
                        'name' => 'Name',
                        'amount' => 'Amount/duration'
                    ],
                    'empty' => 'The list of items is empty'
                ]
            ]
        ],
        'news' => [
            //
        ]
    ],
    'admin' => [
        'control' => [
            'basic' => [
                'basic_section' => 'General information about the store',
                'title' => 'Basic settings',
                'name' => 'Shop name',
                'description' => 'Shop description',
                'keywords' => 'Shop keywords',
                'users_section' => 'Users',
                'access_mode' => [
                    'title' => 'Access mode',
                    'guest' => 'Guests only',
                    'auth' => 'Authorized users only',
                    'any' => 'Both guests and authorized users',
                ],
                'enable_register' => 'Allow new users to register',
                'enable_send_activations' => 'Enable sending emails to users for account verification',
                'custom_url_after_register' => 'Redirect user to custom URL after registration',
                'skin_cloak_section' => 'Skins and cloaks',
                'skin_enabled' => 'Allow users to set skins',
                'hd_skin_enabled' => 'Allow users to set HD skins',
                'cloak_enabled' => 'Allow users to set cloaks',
                'hd_cloak_enabled' => 'Allow users to set HD cloaks',
                'max_skin_file_size' => 'Maximum size of the skin file (KB)',
                'max_cloak_file_size' => 'Maximum size of the raincoat file (KB)',
                'skin_sizes' => 'Acceptable image size of the skin',
                'skin_sizes_hd' => 'The acceptable dimensions of the HD skin image',
                'cloak_sizes' => 'Acceptable image sizes of a cloak',
                'cloak_sizes_hd' => 'The dimensions of the HD cloak image',

                'catalog_section' => 'Catalog',
                'catalog_per_page' => 'Number of products per page of the catalog',
                'sort_products' => [
                    'title' => 'Sort products in catalog',
                    'by_name' => 'By the name of the item (A -> Z)',
                    'by_name_desc' => 'By the name of the item (Z -> A)',
                    'by_priority' => 'By the sort priority of the item (1 -> N)',
                    'by_priority_desc' => 'By the sort priority of the item (N -> 1)',
                ],

                'news_section' => 'News',
                'news_enabled' => 'Enable news feed',
                'news_per_portion' => 'Number of downloads at a time',

                'monitoring_section' => 'Server monitoring',
                'monitoring_enabled' => 'Enable server monitoring',
                'monitoring_rcon_timeout' => 'RCON Connection Timeout (sec.)',
                'monitoring_rcon_command' => 'Player list obtaining command',
                'monitoring_rcon_response_pattern' => 'The regular expression of parsing the server response',

                'service_section' => 'Service',
                'maintenance_mode_enabled' => 'Enable maintenance mode'
            ],
            'payments' => [
                'title' => 'Payment settings',
                'basic_section' => 'Common',
                'min_fill_balance_sum' => 'Minimum balance replenishment sum',
                'currency' => 'Currency text representation',
                'currency_html' => 'Formatted currency representation',
                'aggregators_section' => 'Payment aggregators',
                'robokassa' => [
                    'title' => 'Robokassa',
                    'enabled' => 'Use Robokassa',
                    'login' => 'Login',
                    'payment_password' => 'Password #1',
                    'validation_password' => 'Password #2',
                    'algorithm' => 'Algorithm for calculating the checksum',
                    'test' => 'Test mode'
                ],
                'interkassa' => [
                    'title' => 'Interkassa',
                    'enabled' => 'Use Interkassa',
                    'key' => 'Key',
                    'checkout_id' => 'Checkout ID',
                    'test_key' => 'Test key',
                    'currency' => 'Currency',
                    'algorithm' => 'Algorithm for calculating the checksum',
                    'test' => 'Test mode'
                ]
            ],
            'api' => [
                'title' => 'API',
                'basic' => 'Basic',
                'enabled' => 'Enable API',
                'key' => 'Secret key',
                'delimiter' => 'Arguments delimiter',
                'algorithm' => 'Algorithm for calculating the checksum',
                'functions' => 'Functions',
                'auth' => 'Authorization',
                'auth_enabled' => 'Enable API authentication',
                'register_enabled' => 'Enable user registration API',
                'sashok724s_launcher' => [
                    'title' => 'Integration with Sashok724\'s Launcher',
                    'enabled' => 'Enable integration',
                    'format' => 'Successful service response format',
                    'ips' => 'List of allowed IP addresses'
                ]
            ],
            'security' => [
                'title' => 'Security',
                'recaptcha' => [
                    'title' => 'reCAPTCHA',
                    'enabled' => 'Enable reCAPTCHA form protection',
                    'public_key' => 'Public key',
                    'secret_key' => 'Secret key'
                ],
                'user_section' => 'User',
                'reset_password_enabled' => 'Allow the user to reset the password',
                'change_password_enabled' => 'Allow the user to change the password from their account',
            ],
            'optimization' => [
                'title' => 'Optimization',
                'caching_section' => 'Caching',
                'monitoring_ttl' => 'Server monitoring cache time (minutes)',
                'reset_app_cache' => 'Reset application cache'
            ]
        ],
        'servers' => [
            'add' => [
                'title' => 'Add server',
                'name' => 'Server name',
                'categories' => 'Categories',
                'category_name' => 'Category name',
                'connecting' => 'Connection',
                'ip' => 'Server IP address',
                'port' => 'RCON port',
                'password' => 'RCON password',
                'monitoring_enabled' => 'Enable server monitoring',
                'server_enabled' => 'Enable server',
                'distribution' => 'Products distribution',
                'distributor' => 'Distributor class name',
                'finish' => 'Finish'
            ],
            'edit' => [
                'title' => 'Edit server',
                'finish' => 'Finish editing'
            ],
            'list' => [
                'title' => 'Servers list',
                'categories' => 'Categories',
                'server_id' => 'Server ID',
                'go_to_server' => 'Go to server',
                'delete' => 'Are you sure you want to delete the server ":name"? This will destroy all the data associated with this server (categories, products).'
            ]
        ],
        'products' => [
            'add' => [
                'title' => 'Add product',
                'item' => 'Item',
                'server' => 'Server to which the product will be attached',
                'category' => 'Category to which the product will be attached',
                'no_categories' => 'There are no categories on the selected server.',
                'item_stack' => 'Amount of products in 1 stack',
                'currency_stack' => 'The number of in-game currency in 1 stack',
                'permgroup_stack' => 'Permission group duration',
                'forever' => 'Permission group is acquired forever',
                'price_for_stack' => 'The price of one stack of products',
                'price_for_period' => 'The price of one period of permission group',
                'price_for_currency' => 'Price of a stack of in-game currency',
                'price_for_region' => 'Price of a one region',
                'price_for_command' => 'Price of a one command',
                'sort_priority' => 'Product sort priority in a catalog',
                'hide' => 'Hide product from catalog',
                'finish' => 'Finish adding product'
            ],
            'edit' => [
                'title' => 'Edit product',
                'finish' => 'Finish editing a product'
            ],
            'list' => [
                'title' => 'Products list',
                'search' => 'Search by products',
                'table' => [
                    'headers' => [
                        'id' => 'ID',
                        'price' => 'Price',
                        'stack' => 'Amount/Duration',
                        'image' => 'Image',
                        'item' => 'Item name',
                        'type' => 'Item type'
                    ],
                    'empty' => 'The list of items is empty'
                ],
                'delete' => 'Are you sure you want to delete this item?'
            ]
        ],
        'items' => [
            'add' => [
                'title' => 'Add item',
                'name' => 'Item name',
                'description' => 'Item description',
                'item_id' => 'In-game item identifier',
                'permgroup_id' => 'In-game permission group identifier',
                'region_owner_id' => 'In-game region identifier',
                'region_member_id' => 'In-game region identifier',
                'command' => 'Executable command',
                'image' => [
                    'default' => 'Default',
                    'upload' => 'Upload',
                    'browse' => 'Browse'
                ],
                'browser' => [
                    'title' => 'Images of objects in the server file system',
                    'select' => 'Select an image',
                    'name' => 'File name'
                ],
                'enchantment' => [
                    'title' => 'Enchanting table',
                    'description' => 'Select the intensity of the desired enchants and close the dialog box. Remember, most spells can only be combined with certain enchants.'
                ],
                'extra' => 'Extra',
                'pattern' => 'Response pattern',
                'finish' => 'Complete creation'
            ],
            'edit' => [
                'title' => 'Edit item',
                'finish' => 'Finish editing',
                'image' => [
                    'current' => 'Current'
                ]
            ],
            'list' => [
                'title' => 'Items list',
                'search' => 'Search by items',
                'table' => [
                    'headers' => [
                        'id' => 'ID',
                        'name' => 'Name'
                    ],
                    'loading' => 'Item information is loading...',
                    'empty' => 'The list of items is empty'
                ],
                'delete' => 'Are you sure that you want to delete this ":name"?'
            ],
        ],
        'news' => [
            'add' => [
                'title' => 'Add news',
                'title_input' => 'News title',
                'content' => 'Let\'s do something amazing...',
                'finish' => 'Finish'
            ],
            'edit' => [
                'title' => 'Edit news',
                'finish' => 'Finish editing'
            ],
            'list' => [
                'title' => 'News list',
                'search' => 'Search news',
                'table' => [
                    'headers' => [
                        'id' => 'ID',
                        'title' => 'Title',
                        'username' => 'Author',
                        'created_at' => 'Date and time of creation'
                    ],
                    'loading' => 'News information is loading...',
                    'empty' => 'News list is empty'
                ],
                'delete' => 'Are you sure you want to delete the news?'
            ],
        ],
        'pages' => [
            'add' => [
                'title' => 'Add static page',
                'title_input' => 'Static page title',
                'content' => 'Let\'s do something amazing...',
                'url' => 'Page URL',
                'url_auto' => 'Generate URL automatically',
                'finish' => 'Finish'
            ],
            'edit' => [
                'title' => 'Edit static page'
            ],
            'list' => [
                'title' => 'List of static pages',
                'search' => 'Search static pages',
                'table' => [
                    'headers' => [
                        'id' => 'ID',
                        'title' => 'Title',
                        'url' => 'URL'
                    ],
                    'loading' => 'Information about static pages is loaded...',
                    'empty' => 'The list of static pages is empty'
                ],
                'delete' => 'Are you sure you want to delete the static page?'
            ],
        ],
        'users' => [
            'edit' => [
                'main' => [
                    'title' => 'Edit user',
                    'new_password' => 'New password',
                    'balance' => 'Balance',
                    'roles' => 'User roles',
                    'permissions' => 'User permissions',
                    'finish' => 'Finish editing',
                ],
                'actions' => [
                    'title' => 'User action',
                    'activated_at' => 'User activated at :datetime.',
                    'banned' => 'The user is banned',
                    'show_bans_history' => 'View ban history',
                    'bans_history' => [
                        'title' => ':username ban history',
                        'created_at' => 'Date of blocking',
                        'until' => 'Date of blocking expired',
                        'reason' => 'Reason',
                        'delete' => 'Are you sure you want to delete the ban?',
                        'caption' => 'non-expired bans'
                    ],
                    'show_ban_dialog' => 'Ban user',
                    'show_add_ban_dialog' => 'Add ban to user',
                    'add_ban' => [
                        'forever' => 'Ban permanently',
                        'duration' => 'Duration',
                        'concrete' => 'Concrete',
                        'in_days' => 'In days',
                        'days' => 'Duration of blocking in days',
                        'date' => 'Date of blocking expired',
                        'time' => 'Time of blocking expired',
                        'datetime' => 'Date and time of blocking expired',
                        'reason' => 'Reason',
                        'finish' => 'Block'
                    ],
                    'purchase_history' => [
                        'title' => 'Purchase history'
                    ],
                    'cart' => [
                        'title' => 'In-game cart'
                    ]
                ]
            ],
            'list' => [
                'title' => 'List of users',
                'search' => 'Search by users',
                'table' => [
                    'headers' => [
                        'id' => 'ID',
                        'balance' => 'Balance',
                        'states' => 'States'
                    ],
                    'activated' => 'This user account has been activated',
                    'banned' => 'This user is blocked',
                    'loading' => 'User information is loaded...',
                    'empty' => 'User list is empty'
                ],
                'delete' => 'Are you sure you want to delete the user?'
            ],
            'roles' => [
                'title' => 'Permissions and roles',
                'permissions_table' => [
                    'title' => 'Permissions',
                    'search' => 'Search by permissions',
                    'headers' => [
                        'id' => 'ID',
                        'name' => 'Name'
                    ],
                    'update_name' => 'Update name',
                    'delete' => 'Are you sure you want to delete this permission?',
                    'empty' => 'The list of permissions is empty'
                ],
                'create_permission_dialog' => [
                    'title' => 'Creating a permission',
                    'name' => 'Permission name'
                ],
                'roles_table' => [
                    'title' => 'Roles',
                    'search' => 'Search by roles',
                    'headers' => [
                        'id' => 'ID',
                        'name' => 'Name',
                        'permissions' => 'Permissions'
                    ],
                    'update_name' => 'Update name',
                    'delete' => 'Are you sure you want to delete this role?',
                    'empty' => 'The list of roles is empty'
                ],
                'create_role_dialog' => [
                    'title' => 'Creating a role',
                    'name' => 'Role name',
                    'permissions' => 'Role permissions'
                ],
                'update_role_dialog' => [
                    'title' => 'Updating the permissions of the ":name" role'
                ]
            ]
        ],
        'other' => [
            'rcon' => [
                'title' => 'RCON - console',
                'input' => 'Input command',
                'connection_failed' => 'Could not connect to the server: :message'
            ],
            'debug' => [
                'title' => 'Debug',
                'email' => [
                    'title' => 'Test email',
                    'description' => 'A test mail will help you verify how the email function works.',
                    'address' => 'Email address to which the letter will be sent',
                    'success' => 'The dispatch has been carried out. Check your email.',
                    'failure' => 'The following error occurred while sending the message:',
                    'invalid_address' => 'Invalid email'
                ]
            ]
        ],
        'statistic' => [
            'show' => [
                'title' => 'View statistics',
                'profit_for_year' => 'The dynamics of profit for several years',
                'profit_for_month' => 'Dynamics of profit for the month',
                'purchases_for_year' => 'Dynamics of fulfillment of orders for several years',
                'purchases_for_month' => 'Dynamics of fulfillment of orders for a month',
                'registered_for_year' => 'Dynamics of user registration for several years',
                'registered_for_month' => 'Dynamics of user registration for the month',
                'top_purchased_products' => 'Most buy',
                'table' => [
                    'title' => 'General indicators of the project',
                    'headers' => [
                        'name' => 'Indicator name',
                        'value' => 'Indicator value',
                    ],
                    'items' => [
                        'profit' => 'Total profit',
                        'amount_purchases' => 'Orders successfully completed',
                        'amount_fill_balance' => 'Number of balance replenishment',
                        'users_registered' => 'Registered users'
                    ]
                ]
            ],
            'purchases' => [
                'title' => 'User purchases history'
            ]
        ],
        'information' => [
            'about' => [
                'title' => 'About L-Shop',
                'description' => '<strong>L - Shop</strong> - this is an open source project, an entire e-commerce system,
                The goal is to help administrators of Minecraft gaming servers simplify the process of selling virtual goods.',
                'version' => 'Version :version',
                'lshop_version' => 'L-Shop version: :version',
                'developers_title' => 'Developers',
                'developers' => [
                    'D3lph1' => [
                        'name' => 'Bogdan',
                        'description' => [
                            'plain' => 'Software code: backend and frontend. You can contact me for technical support, as well as for ordering the development of various software.',
                            'html' => '<span class="text--primary">Software code: backend and frontend.</span> You can contact me for technical support, as well as for ordering the development of various software.'
                        ]
                    ],
                    'WhileD0S' => [
                        'name' => 'Michael',
                        'description' => [
                            'plain' => 'Design, layout, frontend. You can contact me in order to order the development of a unique design for your site, including, for a site based on the L-Shop system.',
                            'html' => '<span class="text--primary">Design, layout, frontend.</span> You can contact me in order to order the development of a unique design for your site, including, for a site based on the L-Shop system.'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'layout' => [
        'shop' => [
            'server' => 'Server:',
            'sidebar' => [
                'balance' => [
                    'title' => 'Balance',
                    'replenishment' => 'Replenishment'
                ],
                'basic' => [
                    'title' => 'Store',
                    'catalog' => 'Catalog',
                    'cart' => 'Cart',
                    'servers' => 'To servers'
                ],
                'profile' => [
                    'title' => 'Profile',
                    'character' => 'Character',
                    'settings' => 'Settings',
                    'information' => [
                        'title' => 'Information',
                        'sub_items' => [
                            'purchases' => 'Purchase history',
                            'cart' => 'In-game cart'
                        ]
                    ]
                ],
                'admin' => [
                    'title' => 'Administration',
                    'control' => [
                        'title' => 'Control',
                        'sub_items' => [
                            'main_settings' => 'Basic settings',
                            'payments' => 'Payments',
                            'api' => 'API',
                            'security' => 'Security',
                            'optimization' => 'Optimization'
                        ]
                    ],
                    'servers' => [
                        'title' => 'Servers',
                        'sub_items' => [
                            'add' => 'Add',
                            'edit' => 'Edit'
                        ]
                    ],
                    'products' => [
                        'title' => 'Products',
                        'sub_items' => [
                            'add' => 'Add',
                            'edit' => 'Edit'
                        ]
                    ],
                    'items' => [
                        'title' => 'Items',
                        'sub_items' => [
                            'add' => 'Add',
                            'edit' => 'Edit'
                        ]
                    ],
                    'news' => [
                        'title' => 'News',
                        'sub_items' => [
                            'add' => 'Add',
                            'edit' => 'Edit'
                        ]
                    ],
                    'pages' => [
                        'title' => 'Static pages',
                        'sub_items' => [
                            'add' => 'Add',
                            'edit' => 'Edit'
                        ]
                    ],
                    'users' => [
                        'title' => 'Users',
                        'sub_items' => [
                            'edit' => 'Edit',
                            'roles' => 'Permissions and roles'
                        ]
                    ],
                    'other' => [
                        'title' => 'Other',
                        'sub_items' => [
                            'rcon' => 'RCON - console',
                            'debug' => 'Debug',
                        ]
                    ],
                    'statistic' => [
                        'title' => 'Statistic',
                        'sub_items' => [
                            'show' => 'View statistics',
                            'payments' => 'Purchase history'
                        ]
                    ],
                    'info' => [
                        'title' => 'Information',
                        'sub_items' => [
                            'docs' => 'Documentation',
                            'about' => 'About L-Shop',
                        ]
                    ]
                ]
            ],
            'settings' => [
                'title' => 'Local settings'
            ],
            'monitoring' => [
                'title' => 'Server monitoring',
                'disabled' => 'Disabled',
                'failed' => 'Failed'
            ]
        ],
        'news' => [
            'title' => 'News',
            'empty' => 'No news',
            'read' => 'Read more',
            'load' => 'Load more'
        ]
    ],
    'errors' => [
        '403' => [
            'title' => 'forbidden',
            'description' => 'Access to the requested page is forbidden.'
        ],
        '404' => [
            'title' => 'Not found',
            'description' => 'The page you requested is not found.',
        ],
        '500' => [
            'title' => 'Internal server error',
            'description' => 'Internal server error.'
        ],
        '503' => [
            'title' => 'Temporarily unavailable',
            'description' => 'The service is temporarily unavailable, technical work is being carried out. Come back later.'
        ]
    ]
];
