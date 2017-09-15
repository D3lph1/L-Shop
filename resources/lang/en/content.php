<?php

return [
    'admin' => [
        'save' => 'Save changes',

        'control' => [
            'main_settings' => [
                'title' => 'Main settings',
                'shop' => [
                    'title' => 'Shop',
                    'edit_info' => 'Edit the basic information about the shop.',
                    'name' => 'Shop name',
                    'name_popover' => 'The name of the shop will be displayed on the main page and also in the page titles.',
                    'description' => 'Shop description',
                    'description_popover' => 'The description of the shop is used mainly by search engines to index the resource.',
                    'keywords' => 'Keywords',
                    'keywords_popover' => 'Keywords are used mainly by search engines for indexing a resource. They must be separated by commas without spaces.',

                    'sort_attr' => 'Sort products by',
                    'sort_attr_name' => 'The name of the item (A -> Z)',
                    'sort_attr_name_desc' => 'The name of the item (Z -> A)',
                    'sort_attr_sort_priority' => 'Priority of products sorting (1 -> N)',
                    'sort_attr_sort_priority_desc' => 'Priority of products sorting (N -> 1)',

                ],
                'access_mode' => [
                    'title' => 'Access mode',
                    'description' => 'This setting controls how users can access the store.<br>
                        <strong> Only guests </strong>: Authorization in the store is disabled, users will purchase products without signing in.<br>
                        <strong> Authorized users only </strong>: Authorization in the store is mandatory, the products can be purchasedOnly users logged into your account. <br>
                        <strong> Both guests and authorized users </strong>: Users can make purchases both by logging in to the account, and without entering it.',
                    'guest' => 'Only guests',
                    'auth' => 'Only authorized users',
                    'all' => 'Both guests and authorized users',
                ],
                'register' => [
                    'title' => 'Signup',
                    'enable' => 'Allow new user registration',
                    'send_mail' => 'Enable sending emails to users for account verification',
                    'send_mail_popover' => 'If this option is enabled, after the registration, the user will be sent an email to the email address specified by the user. This is necessary in order to confirm the validity of the e-mail address.',
                    'redirect' => 'Redirect user to custom URL after registration',
                    'redirect_popover' => 'If the option is enabled, after registration, the user will be redirected to the URL that is specified in the field below.',
                    'url' => 'Custom URL',
                ],
                'skins' => [
                    'title' => 'Skins and cloaks',
                    'enable' => 'Allow users to set skins',
                    'enable_popover' => 'Players will be able to install <strong> skins </strong> for their characters. If you disabled the ability to install HD skins, then the skin size should be equal to <strong> 64x32 </strong> pixel.',
                    'hd' => 'Allow users to set HD skins',
                    'hd_popover' => 'Players will be able to install <strong> HD skins </strong> for their characters. The maximum image size is <strong> 1024x512 </strong>.',
                    'size' => 'Maximum size of the skin file',
                    'size_popover' => 'The size should be specified in <strong> kilobytes</strong>.',
                ],
                'cloaks' => [
                    'enable' => 'Allow users to set cloaks',
                    'enable_popover' => 'Players will be able to install <strong> cloaks </strong> for their characters. If you disabled the ability to install HD raincoats, then the image size should be equal to <strong> 22x17 </strong> pixel.',
                    'hd' => 'Allow users to set HD cloaks',
                    'hd_popover' => 'Players will be able to install <strong> HD cloaks </strong> for their characters. The maximum image size is <strong> 1024x512 </strong>.',
                    'size' => 'Maximum size of the cloak file',
                    'size_popover' => 'The size should be specified in <strong> kilobytes</strong>.',
                ],
                'news' => [
                    'title' => 'News',
                    'enable' => 'Enable news feed',
                    'first_portion' => 'Number of news items on the screen at boot time',
                    'load_portion' => 'Number of downloads at a time'
                ],
                'pagination' => [
                    'title' => 'Pagination',
                    'shop_products_per_page' => 'Number of products per shop page',
                    'profile_payments_per_page' => 'Number of items on the payment history page in the user profile',
                    'profile_in_game_cart_per_page' => 'Number of items on the page of the in-game shopping cart in the user\'s profile',
                ],
                'cart' => [
                    'title' => 'Cart',
                    'capacity' => 'Maximum capacity of the basket'
                ],
                'monitoring' => [
                    'title' => 'Monitoring',
                    'enable' => 'Enable server monitoring',
                    'timeout' => 'Connection timeout',
                    'timeout_popover' => 'The time after which the connection to the server socket will be automatically disconnected. (If there is no connection). Specify in seconds.',
                ],
                'maintenance' => [
                    'title' => 'Maintenance mode',
                    'description' => 'Enable / disable maintenance mode. This mode closes the access to the site.
                        Access will only be open to administrators. An authorization page will also be available
                        (You can change the list of available routes in the <code> except </code> property
                        Intermediary <code>App\Http\Middleware\CheckForMaintenanceMode </code>).
                        At the same time, anyone who entered the site will be shown a message. Edit it you
                        You can in the <code>resources/view/errors/503.blade.php</code> file.',
                    'enable' => 'Enable maintenance mode'
                ]
            ],
            'payments' => [
                'title' => 'Payments',
                'common' => [
                    'title' => 'Common',
                    'min_sum' => 'Minimum balance recharge amount',
                    'currency' => 'Currency',
                    'currency_name' => 'Currency name',
                    'currency_html' => 'HTML representation of currency',
                ],
                'aggregators' => [
                    'title' => 'Payment aggregators',
                    'robokassa' => [
                        'title' => 'Robokassa',
                        'enabled' => 'Enable Robokassa',
                        'change_data' => 'Changing the personal data of the Robokassa service',
                        'login' => 'Login',
                        'password1' => 'Password №1',
                        'password2' => 'Password №2',
                        'algo' => 'Algorithm for calculating the checksum',
                        'is_test' => 'Test mode',
                    ],
                    'interkassa' => [
                        'title' => 'Interkassa',
                        'enabled' => 'Enable Interkassa',
                        'change_data' => 'Changing the personal data of the Interkassa service',
                        'login' => 'Checkout identifier',
                        'key' => 'Key',
                        'currency' => 'Currency',
                        'test_key' => 'Test key',
                        'algo' => 'Algorithm for calculating the checksum',
                        'is_test' => 'Test mode',
                    ],
                ]
            ],
            'api' => [
                'title' => 'API',
                'api_enable_alert' => 'Be sure to enable the API before using it.',
                'api_doc_alert' => 'Detailed API documentation can be found',
                'api_doc_alert_btn' => 'here',
                'enable_api' => [
                    'title' => 'Enable API',
                    'enable' => 'Enable',
                ],
                'key' => [
                    'title' => 'Access key',
                    'description' => 'With this key, all interactions of your resource with the l-shop API will take place. The key length can not be less than 32 characters.',
                    'secret_key' => 'The secret key',
                    'alert' => 'Never tell anyone this key! Otherwise, the security of the application will be at risk.',
                ],
                'algo' => [
                    'title' => 'Hash algorithm',
                    'description' => 'Using this algorithm, the checksum of the string will be calculated. This is necessary to perform a secure API request.',
                    'alert' => 'We <strong> do not recommend </strong> to use the <strong>md5</strong> algorithm, due to its low resiliency.'
                ],
                'separator' => [
                    'title' => 'Delimiter of arguments',
                    'description' => 'This symbol will separate the parameters in the string from which the checksum will be calculated.',
                    'input' => 'Separator',
                ],
                'auth' => [
                    'title' => 'API - authorization',
                    'enable' => 'Enable',
                    'remember' => 'Remember Authenticated Users'
                ],
                'register' => [
                    'title' => 'API - registration',
                    'enable' => 'Enable',
                ],
                'sashok' => [
                    'title' => 'Integration with Sashok724\'s launcher',
                    'enable' => 'Enable',
                    'success_response' => [
                        'title' => 'Successful service response format',
                        'description' => 'This line will be "displayed" to the launcher if the entered data is successfully verified.
                            The {username} token will be replaced with the username. For example, if the answer format is OK: {username}, if successful
                            Verification of user data D3lph1, the server will receive the response: OK: D3lph1.',
                        'format' => 'Format'
                    ],
                    'fail_response' => [
                        'input' => 'Message when the user enters the data incorrectly'
                    ],
                    'whitelist' => [
                        'description' => 'Below you can enter a list of ip-addresses that can connect to the L-Shop and check user data for authorization in the launcher.
                            We recommend that you specify here your ip launcher. Leave the field blank so that you do not use blocking of foreign addresses (Not recommended).',
                        'input' => 'List of allowed IP addresses (Separator - comma, for example: 127.0.0.1, 192.168.0.1).'
                    ]
                ]
            ],
            'security' => [
                'title' => 'Security',
                'debug_mode_alert' => '<p> <strong>Warning:</strong> You have debug mode enabled. Visitors to your site can see the debugging
                    Information, and also, errors. Without fail, disable this mode in the "production", setting the value
                    Of the <code> APP_DEBUG </code>element in the <code>.env</code> file to <code> false </code>. </p>
                    To get it this way: <code>APP_DEBUG=false</code>',
                'generator' => [
                    'title' => 'Key generator',
                    'description_app_key' => 'This tool helps to create an application key',
                    'description_app_key_instruction' => '<p> Set this key to the value of the <code> APP_KEY </code> element in the <code> .env </code> </p> file
                        It should look like this: <code>APP_KEY={{ $key }}</code>',
                    'description_app_key_notify' => '<strong>Warning:</strong> After changing the application key, all users (including you) will be disconnected.',
                    'description_app_auth_key' => 'And this is the key of the session:',
                    'description_app_auth_key_instruction' => '<p> Set this key to the value of the <code> APP_AUTH_KEY </code> element in the <code> .env </code> </p> file
                        It should look like this: <code>APP_AUTH_KEY={{ $key }}</code>',
                    'description_app_auth_key_notify' => 'Never tell these keys to anyone! Otherwise, the security of the application will be at risk.',
                ],
                'recaptcha' => [
                    'title' => 'reCAPTCHA',
                    'description' => 'Change the reCAPTCHA service keys.',
                    'public_key' => 'Public key',
                    'secret_key' => 'The secret key',
                    'check' => 'Check',

                    'modal' => [
                        'title' => 'Checking ReCAPTCHA',
                        'btn' => 'Ok',
                    ]
                ],
                'user' => [
                    'title' => 'User',
                    'allow_change_password' => 'Allow the user to change the password from their account',
                    'allow_reset_password' => 'Allow the user to reset the password',
                ]
            ],
            'optimization' => [
                'title' => 'Optimization',
                'caching' => [
                    'title' => 'Caching',
                    'statistic_ttl' => 'The lifetime of the statistics cache (minutes)',
                    'statistic_ttl_popover' => 'After this time, the store statistics cache will be deleted and then updated.',
                    'pages_ttl' => 'Cache lifetime of static pages (minutes)',
                    'pages_ttl_popover' => 'After this time, the cache of static pages will be deleted and then updated.',
                    'news_ttl' => 'The lifetime of the news cache (minutes)',
                    'news_ttl_popover' => 'After this time, the news cache will be deleted and then updated.',
                    'monitoring_ttl' => 'Server monitoring cache time (minutes)',
                    'monitoring_ttl_popover' => 'After this time, the server monitoring cache will be deleted and then updated.',

                    'routes_cache' => [
                        'title' => 'Update route cache',
                        'description' => 'Description of the routes by which the system determines what action to associate with a particular url
                            Scattered in files and presented in a human-readable format. Updating the route cache
                            Allows you to generate a file in which the routes will be stored in a "convenient" way for the system and,
                            Most, speed up the execution of requests.',
                    ],
                    'config_cache' => [
                        'title' => 'Update configuration cache',
                        'description' => 'To increase the speed of work, Laravel caches the settings. After clicking on the button below, the cache will be deleted,
                            And then generated again. This function can be useful if you have changed the values of any
                            Settings in the configuration files.',
                    ],
                    'templates_cache' => [
                        'title' => 'Clear template cache',
                        'description' => 'The framework on which the L-Shop is based, for the convenience of development, uses the Blade template engine.
                            Blade caches views in order to increase the speed of work. You may need to clear
                            This cache. It will be recreated after updating each page of the site.',
                    ],
                    'app_cache' => [
                        'title' => 'Clear application cache',
                        'description' => 'To achieve the best performance, L-Shop caches many data to "get" them from
                            Cache, and not "drag" from the database. The button below will help clear all this information. It will be recreated
                            Automatically when required.',
                    ]
                ],
            ]
        ],
        'servers' => [
            'add' => [
                'title' => 'Add Server',
                'name' => 'Server name',
                'categories' => [
                    'title' => 'Categories',
                    'name' => 'Category name',
                    'add' => 'Add category'
                ],
                'ip' => 'Server IP address',
                'port' => 'RCON server port',
                'password' => 'RCON password',
                'monitoring' => 'Enable server monitoring',
                'enable' => 'Enable server',
                'save' => 'Save'
            ],
            'edit' => [
                'title' => 'Edit :name server',
                'new_category_name' => 'Name of the new category',
                'remove' => 'Delete server'
            ],
            'list' => [
                'title' => 'Edit servers',
                'create' => 'Create server',
                'edit' => 'Edit',
                'enable' => 'Enable',
                'disable' => 'Disable',
            ]
        ],
        'products' => [
            'add' => [
                'title' => 'Add product',
                'attach_item' => 'Assign item/privilege',
                'products_in_stack' => 'Quantity of products in 1 stack',
                'perm_duration' => 'Duration of the privilege (in days). 0 - forever',
                'products_price' => 'Price per stack of products',
                'perm_price' => 'The price of one privilege period',
                'sort_priority' => 'Sort priority',
                'sort_priority_popover' => 'Sort priority is a fractional or integer, positive or negative number. By this value, goods will be sorted in the directory (This mode can be enabled/disabled in <strong> Administration > Basic Settings </strong>).',
                'attach_server_category' => 'Assign to server/category',
                'save' => 'Save'
            ],
            'edit' => [
                'title' => 'Edit product',
                'remove' => 'Delete product'
            ],
            'list' => [
                'title' => 'Edit products',
                'add' => 'Add products',
                'sort' => [
                    'title' => 'Sort',
                    'without' => 'Without sorting',
                    'id' => 'By identifier',
                    'id_desc' => 'By identifier, descend',
                    'name' => 'By name',
                    'name_desc' => 'By name, descend'
                ],
                'filter' => [
                    'title' => 'Filer',
                    'without' => 'Without filtering'
                ],
                'table' => [
                    'id' => 'ID',
                    'image' => 'Image of the item',
                    'name' => 'Item name',
                    'price' => 'Price (per stack)',
                    'count' => 'Count/Duration',
                    'server' => 'Server',
                    'category' => 'Category',
                    'edit' => 'Edit'
                ],
                'empty' => 'The list of products is empty...'
            ]
        ],
        'items' => [
            'add' => [
                'title' => 'Add item',
                'item_name' => 'Item name',
                'perm_name' => 'Privilege name',
                'type' => [
                    'title' => 'Type',
                    'item' => 'Item/Block',
                    'perm' => 'Privilege',
                ],
                'image' => [
                    'title' => 'Image type',
                    'default' => 'Default image',
                    'load' => 'Upload image',
                    'select' => 'Select an image',
                    'not_selected' => 'No image selected'
                ],
                'item_id' => 'In-game ID or ID:DATA of item',
                'perm_id' => 'In-game privilege identifier',
                'extra' => 'Extra'
            ],
            'edit' => [
                'title' => 'Edit item',
                'image' => [
                    'current' => 'Current'
                ],
                'remove' => 'Delete item'
            ],
            'list' => [
                'title' => 'Edit items',
                'add' => 'Add item',
                'table' => [
                    'id' => 'ID',
                    'image' => 'Image',
                    'name' => 'Name',
                    'type' => 'Type',
                    'extra' => 'Extra',
                    'edit' => 'Edit',
                ],
                'empty' => 'The list of items is empty ...'
            ]
        ],
        'news' => [
            'add' => [
                'title' => 'Add news',
                'name' => 'News title',
                'placeholder' => 'Let\'s do something amazing...',
                'publish' => 'Publish',
            ],
            'edit' => [
                'title' => 'Edit news',
                'remove' => 'Delete news'
            ],
            'list' => [
                'title' => 'Edit news',
                'add' => 'Add news',
                'table' => [
                    'id' => 'ID',
                    'name' => 'Title',
                    'author' => 'Author',
                    'published_at' => 'Date of publication',
                    'updated_at' => 'Last edited date',
                    'edit' => 'Edit'
                ],
                'empty' => 'No news yet...'
            ]
        ],
        'pages' => [
            'add' => [
                'title' => 'Add static page',
                'name' => 'Page title',
                'placeholder' => 'Let\'s do something amazing...',
                'generate' => 'Generate automatically',
                'address' => 'page address',
                'access' => 'You can access the page by clicking on the link: <strong>:url</strong>',
                'save' => 'Save this page',
            ],
            'edit' => [
                'title' => 'Edit static page',
                'remove' => 'Delete page'
            ],
            'list' => [
                'title' => 'Edit static pages',
                'add' => 'Add static page',
                'table' => [
                    'id' => 'ID',
                    'name' => 'Title',
                    'url' => 'URL',
                    'created_at' => 'Date added',
                    'updated_at' => 'Last edited date',
                    'edit' => 'Edit'
                ],
                'empty' => 'No static pages yet ...'
            ]
        ],
        'users' => [
            'edit' => [
                'title' => 'Edit user :username',
                'unblock' => 'Unlock',
                'username' => 'Username',
                'email' => 'Email',
                'balance' => 'Balance',
                'password' => 'New password',
                'other' => [
                    'title' => 'Other',
                    'in_game_cart' => 'View in-game shopping cart',
                    'sessions' => 'Reset all login - sessions of this user',
                    'block' => 'Block user'
                ],
                'remove' => 'Delete user',
                'cart_modal' => [
                    'title' => 'View in-game shopping cart',
                    'btn' => 'Ok',
                    'table' => [
                        'image' => 'Image',
                        'item' => 'Item',
                        'count' => 'Count/Duration',
                        'server' => 'Server'
                    ],
                    'empty' => 'Your cart is empty'
                ],
                'block_modal' => [
                    'title' => 'Block user',
                    'btn' => 'Block',
                    'cancel' => 'Cancel',
                    'duration' => 'Duration of blocking',
                    'duration_popover' => 'The length of the user\'s blocking in days is indicated here. In order to block the user permanently, enter zero (0).',
                    'reason' => 'Reason for blocking',
                    'reason_popover' => 'The reason for the blocking is indicated, so that you and the user himself knew about what his account was blocked for. This field is optional.',
                ]
            ],
            'list' => [
                'title' => 'Edit Users',
                'search' => [
                    'placeholder' => 'Search Users',
                    'lets_typing' => 'Start typing ...',
                    'nothing' => 'Nothing found',
                    'wait' => 'Search...',
                    'popover' => 'Enter here login, mail, balance, in order to search by users. Also, you can search for users using spets. regulations.
                        So, the query <strong>&gt;520</strong> will select all users whose balance is greater than 520. <strong>&lt;100 </strong> - less than 100. <strong> = 0 </strong> - Those with whom There is no money on the balance sheet.'
                ],
                'table' => [
                    'id' => 'ID',
                    'username' => 'Username',
                    'email' => 'Email',
                    'balance' => 'Balance',
                    'admin' => 'Admin',
                    'edit' => 'Edit',
                    'status' => 'Account status',
                    'blocked' => 'Blocked',
                    'blocked_popover_title' => 'Lock information',
                    'activated' => 'Confirmed',
                    'activated_popover_title' => 'Confirmation Information',
                    'activate' => 'Confirm',
                    'activated_info' => 'Account of this user confirmed at :date.'
                ]
            ]
        ],
        'other' => [
            'rcon' => [
                'title' => 'RCON console',
                'select_server' => 'First, select the server.',
                'enter_cmd' => 'Enter the command',
                'exec' => 'Execute',
                'options' => 'Options',
                'hide_sent' => 'Hide sent items',
                'colorize' => 'Colorize the answer',
                'colorize_popover' => 'The Minecraft server sends color messages using its own formatting. If this option is enabled, the system will convert the special. Characters in HTML markup, understandable to the browser.',
            ],
            'debug' => [
                'title' => 'Debugging',
                'mail' => [
                    'title' => 'Email',
                    'description' => 'The test letter will help to check how the function of sending email messages works.',
                    'address' => 'E-mail address to which the letter will be sent',
                    'send' => 'Send',
                    'fail' => 'An error occurred while sending the message:',
                    'fail_log' => 'Full information about it, as well as the stack traces were written to the log.',
                ]
            ],
            'statistics' => [
                'show' => [
                    'title' => 'View statistics',
                    'orders_per_year' => 'Dynamics of committed orders for this year:',
                    'profit_per_year' => 'The dynamics of profit for this year:',
                    'orders_per_month' => 'Dynamics of committed orders for',
                    'profit_per_month' => 'The dynamics of profit for',
                    'profit' => 'Total profit: :profit :currency',
                    'clear_cache' => 'Clear cache statistics'
                ],
                'payments' => [
                    'title' => 'Customer purchase and payment history',
                    'table' => [
                        'user' => 'User',
                    ]
                ]
            ],
            'info' => [
                'about' => [
                    'title' => 'About L-Shop',
                    'description' => '<strong>L - Shop</strong> is an open source project, an entire system designed to help administrators of Minecraft gaming servers simplify the process of selling virtual goods.',
                    'lshop_version' => 'L-Shop system version',
                    'laravel_version' => 'The version of the Laravel framework',
                    'github' => 'GitHub repository',
                    'rubukkit' => 'Topic on RuBukkit.org',
                    'developers' => 'Developers',
                    'd3lph1_description' => '<strong>Software code</strong>. You can contact me for technical support.',
                    'whiled0s_description' => '<strong>Design and layout</strong>. You can apply to me in order to order the development of a unique design for your site, including for a site based on the L-Shop system.',
                ],
                'docs' => [
                    'title' => 'Documentation',
                    'main' => 'Basic information on using the system',
                    'api' => 'API L - Shop Documentation',
                    'sashok' => 'Sashok724\'s Launcher integration guide',
                    'cli' => 'CLI L - Shop Documentation',
                    'read' => 'Read'
                ]
            ]
        ]
    ],
    'shop' => [
        'server_name' => 'Server: ',
        'catalog' => [
            'title' => 'Catalog',
            'category_empty' => 'Category is empty',
            'item' => [
                'forever' => 'Forever',
                'for' => 'for',
                'items' => '',
                'duration' => 'day(s)',
                'already_in_cart' => 'Already in the cart',
                'put_in_cart' => 'Put in cart',
                'fast_buy' => 'Fast buy',
            ],
            'fast_buy_modal' => [
                'title' => 'Fast buy',
                'next_btn' => 'Continue',
                'cancel_btn' => 'Cancel',
                'username' => 'Username',
                'auth' => 'Your account will be charged the amount of :span :currency
                    If funds are not enough, you will be automatically redirected to the payment page.',
                'guest' => 'You will be redirected to the payment method selection page. Order amount: :span :currency',
            ]
        ],
        'cart' => [
            'title' => 'Cart',
            'username' => 'Username',
            'total' => 'Total:',
            'pay' => 'Form and pay',
            'empty' => 'Your cart is empty',
            'item' => [
                'remove' => 'Remove',
                'count' => 'Count',
                'duration' => 'duration (day(s))',
                'forever' => 'This product is purchased forever.',
                'total' => 'To pay:'
            ]
        ],
        'news' => [
            'read_more' => 'Read more ...',
            'empty' => 'No news'
        ]
    ],
    'profile' => [
        'fillupbalance' => [
            'title' => 'Fill up balance',
            'sum' => 'Sum',
            'pay' => 'Pay'
        ],
        'settings' => [
            'title' => 'Settings',
            'security' => [
                'title' => 'Security',
                'change_password' => 'Change password',
                'password' => 'New password',
                'password_confirmation' => 'Confirm password',
            ],
            'sessions' => [
                'title' => 'Reset of login sessions',
                'description' => 'After clicking on the button below, all login sessions (including the current one) will be reset. This may be
                    Useful when you want to log out of the account on devices that you do not have access to.',
                'reset' => 'Reset'
            ]
        ],
        'character' => [
            'title' => 'Character',
            'select_file' => 'Select a file',
            'update' => 'Update',
            'max_file_size' => 'The maximum file size is <strong>:size</strong> KB.',
            'skin' => [
                'max_image_size' => 'Image size is <strong>64x32</strong>.',
                'max_image_size_hd' => 'The maximum image size is <strong>1024x512</strong>.',
            ],
            'clock' => [
                'not_set' => 'Cloak not set',
                'max_image_size' => 'Image size is <strong>22x17</strong>.',
                'max_image_size_hd' => 'The maximum image size is <strong>1024x512</strong>.',
            ]
        ],
        'payments' => [
            'title' => 'Purchase and payment history',
            'table' => [
                'id' => 'ID',
                'type' => 'Type',
                'products' => 'Products',
                'sum' => 'Sum',
                'status' => 'Status',
                'created_at' => 'Created at',
                'completed_at' => 'Completed at',
                'service' => 'Service',
                'actions' => 'Actions',
                'shopping' => 'Shopping',
                'fillupbalance' => 'Fill up balance',
                'more' => 'Show more ...',
                'completed' => 'Completed',
                'not_completed' => 'Not completed',
                'complete' => 'Complete',
                'pay' => 'Pay now',
                'empty' => 'Payment history is empty',
                'details_modal' => [
                    'title' => 'Information about payment products',
                    'btn' => 'Ok',
                    'table' => [
                        'image' => 'Image',
                        'name' => 'Name',
                        'count' => 'Count',
                    ]
                ]
            ]
        ],
        'cart' => [
            'title' => 'In-game shopping cart',
            'description' => 'On this page you can see all the products that you have purchased, but not yet taken in the game.',
            'any' => 'Any',
            'table' => [
                'image' => 'Image',
                'item' => 'Item',
                'count' => 'Count/Duration'
            ],
            'empty' => 'Your cart is empty'
        ]
    ],

    'monitoring' => [
        'title' => 'Server monitoring',
        'cancel' => 'Cancel',
        'server_disabled' => 'Server is disabled'
    ],

    'payments' => [
        'methods' => [
            'title' => 'Select a Payment Method',
            'nothing' => 'There are no payment methods available'
        ]
    ],

    'auth' => [
        'signin' => [
            'title' => 'Signin',
            'only_for_admins' => 'Signin only for admins',
            'btn' => 'Signin',
            'forgot' => 'I forgot password',
            'signup' => 'Signup',
            'guest' => 'Purchase without authorization',
        ],
        'signup' => [
            'title' => 'Signup',
            'btn' => 'Signup',
            'signin' => 'Signin',
        ],
        'servers' => [
            'title' => 'Select server',
            'signin' => 'Signin'
        ],
        'forgot' => [
            'title' => 'Password recovery',
            'btn' => 'Continue'
        ],
        'reset_password' => [
            'title' => 'Password reset',
            'password' => 'New password',
            'password_confirmation' => 'Repeat new password',
            'btn' => 'Reset',
        ],
        'activate_wait' => [
            'title' => 'Activation',
            'description' => 'A letter with confirmation of registration was sent to the mailbox you specified during registration.
                Check the mail and follow the link in the email.<br>
                If the letter does not come, you can send it out.',
            'repeat' => 'Resend'
        ]
    ],

    'errors' => [
        '403' => [
            'title' => '403 | Forbidden',
            'content' => 'Forbidden',
            'btn' => 'To index page',
        ],
        '404' => [
            'title' => '404 | Not found',
            'content' => 'The page you requested could not be found.',
            'btn' => 'To index page',
        ],
        '500' => [
            'title' => '500 | Internal server error',
            'content' => 'Whoops, looks like something went wrong.'
        ],
        '503' => [
            'title' => '503 | Service is temporarily unavailable',
            'content' => 'Service is temporarily unavailable'
        ]
    ],

    'all' => [
        'save' => 'Save',
        'update' => 'Update',
        'clear' => 'Clear',
        'copy' => 'Copy',
        'select' => 'Select',
        'yes' => 'Yes',
        'no' => 'No',
        'server' => 'Server',
        'username' => 'Username',
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Confirm password',
        'logout' => 'Logout'
    ],
    'months' => [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
    ]
];
