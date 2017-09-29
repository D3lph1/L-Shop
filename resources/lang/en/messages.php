<?php

return [
    'admin' => [
        'changes_saved' => 'Changes successfully saved!',
        'control' => [
            'optimization' => [
                'update_routes_cache_success' => 'Route cache successfully updated!',
                'update_config_cache_success' => 'The configuration cache was successfully updated!',
                'update_view_cache_success' => 'The template cache has been successfully cleared!',
                'update_app_cache_success' => 'The application cache has been successfully cleaned!',
                'update_app_cache_fail' => 'Could not clear application cache.',
            ],
            'payments' => [
                'robokassa' => [
                    'unknowns_algo' => 'Such an algorithm for calculating the checksum for Robokassa is not in the list.'
                ],
                'interkassa' => [
                    'unknowns_algo' => 'Such an algorithm for calculating the checksum for Interkassa is not in the list.'
                ],
            ]
        ],
        'servers' => [
            'add' => [
                'success' => 'The server ":name" was successfully created.',
                'fail' => 'Failed to create server.',
                'category' => [
                    'add' => [
                        'success' => 'The category ":name" is created.'
                    ],
                    'remove' => [
                        'success' => 'Category removed.',
                        'last' => 'There must be at least one category for this server.'
                    ]
                ]
            ],
            'list' => [
                'enable' => [
                    'success' => 'Server is enabled.',
                    'fail' => 'Could not start the server!',
                ],
                'disable' => [
                    'success' => 'Server is disabled.',
                    'fail' => 'Failed to disconnect the server!',
                ],
            ],
            'remove' => [
                'success' => 'The server was deleted.',
                'last' => 'You can not delete the last server!',
            ]
        ],
        'items' => [
            'add' => [
                'success' => 'The item was created successfully.',
                'fail' => 'The item could not be created.'
            ],
            'edit' => [
                'success' => 'Item changed successfully.',
                'not_found' => 'Item not found.',
                'fail' => 'The item could not be edited.'
            ],
            'remove' => [
                'success' => 'The item is removed together with the goods attached to it.',
                'fail' => 'Failed to delete item.'
            ]
        ],
        'products' => [
            'add' => [
                'item_not_found' => 'Item with id :id not found.',
                'success' => 'The product was added.',
                'fail' => 'There was a problem adding the product.',
            ],
            'edit' => [
                'success' => 'Item successfully updated.',
                'fail' => 'There was an error updating the product.'
            ],
            'remove' => [
                'success' => 'Item was deleted.',
                'fail' => 'Failed to delete the product.'
            ]
        ],
        'news' => [
            'add' => [
                'success' => 'The news was successfully published!',
                'fail' => 'We could not post the news.'
            ],
            'edit' => [
                'success' => 'The news has been successfully updated!',
                'fail' => 'Failed to update the news.'
            ],
            'remove' => [
                'success' => 'The news was deleted.',
                'fail' => 'Failed to delete news item.'
            ],
        ],
        'pages' => [
            'url_already_exists' => 'A page with this address already exists!',
            'add' => [
                'success' => 'Page successfully created!',
                'fail' => 'Could not create page.'
            ],
            'edit' => [
                'success' => 'Page successfully updated!',
                'fail' => 'Failed to update page.'
            ],
            'delete' => [
                'success' => 'The page has been deleted.',
                'fail' => 'Failed to delete page.'
            ]
        ],
        'users' => [
            'edit' => [
                'block' => [
                    'successful' => [
                        'temporarily' => [
                            'with_reason' => 'The account of this user is blocked until :until because of ":reason".',
                            'without_reason' => 'This user\'s account has been locked to :until.'
                        ],
                        'permanently' => [
                            'with_reason' => 'The account of this user is locked forever due to ":reason".',
                            'without_reason' => 'This user\'s account is permanently locked.'
                        ],
                    ],
                    'fail' => 'The user could not be blocked.',
                    'not_found' => 'User is not found.',
                    'cannot_block_yourself' => 'You can not block yourself.',
                ],
                'unblock' => [
                    'success' => 'The user is unlocked.',
                    'fail' => 'Unable to unblock user.',
                    'not_found' => 'User is not found.'
                ],
                'save' => [
                    'success' => 'User successfully changed.',
                    'fail' => 'Change the user failed due to an error.',
                    'username_already_exists' => 'Username :username is already in use.',
                    'email_already_exists' => 'Email address :email is already in use.',
                    'not_found' => 'User is not found.'
                ],
                'remove' => [
                    'self' => 'You can not remove yourself.',
                    'not_found' => 'A user with this ID was not found.',
                    'success' => 'The user has been deleted.'
                ],
                'sessions' => [
                    'success' => 'The login session of this user has been successfully reset!',
                    'fail' => 'Could not reset the login session of this user!'
                ]
            ],
            'list' => [
                'activate' => [
                    'success' => 'User account verified.',
                    'fail' => 'Unable to activate user.',
                    'already' => 'The user account has already been verified.',
                ]
            ]
        ],
        'other' => [
            'debug' => [
                'mail' => [
                    'success' => 'Message sent successfully!',
                    'fail' => 'The message could not be sent.'
                ]
            ]
        ],
        'rcon' => [
            'selected_server' => 'Server selected:',
            'empty_input' => 'You should enter the command!',
            'connect_error' => 'Could not connect to socket.'
        ],
        'statistics' => [
            'show' => [
                'clear_cache_success' => 'Statistics cache cleared!'
            ],
            'payments' => [
                'complete' => [
                    'success' => 'Payment successfully verified.',
                    'already_complete' => 'The payment has already been completed.',
                    'not_found' => 'Payment not found.',
                ]
            ]
        ]
    ],
    'api' => [
        'disabled' => 'Disabled',
        'forbidden' => 'Access is denied'
    ],
    'auth' => [
        'signin' => [
            'welcome' => 'Welcome, :username.',
            'frozen' => 'You made too many login attempts. The authorization option will not be available later :delay seconds.',
            'not_activated' => 'Your account has not been activated. Check your mail for our letter.',
            'only_for_admins' => 'Log in to common users is prohibited.',
            'invalid_credentials' => 'A user with this credentials was not found.'
        ],

        'signup' => [
            'success' => 'You are successfully registered!',
            'fail' => 'The user could not be registered because of an internal server error.',
            'username_already_exists' => 'Username :username is already in use.',
            'email_already_exists' => 'Email address :email is already in use.',
            'disabled'=> 'The registration function is disabled.'
        ],

        'forgot' => [
            'success' => 'An email with instructions on resetting your password has been sent to your e-mail.',
            'user_not_found' => 'A user with this email address was not found!',
            'disabled' => 'The project administration has disabled the ability to recover the password.'
        ],

        'reset' => [
            'success' => 'Password changed successfully.',
            'fail' => 'Failed to change password.',
            'invalid_code' => 'The password reset code does not exist or the password recovery period has expired.',
        ],

        'activation' => [
            'success' => 'Your account has been successfully activated!',
            'fail' => 'The activation code is invalid or outdated.',
            'user_not_found' => 'A user with this email address could not be found.',
            'already' => 'This account has already been verified.',
            'repeat' => 'The message to the mail has been sent again.',
        ],

        'logout' => 'You left the account.'
    ],

    'profile' => [
        'password' => [
            'success' => 'Password changed successfully!',
            'fail' => 'Failed to change password.',
            'disabled' => 'The ability to change the password is disabled.'
        ],
        'settings' => [
            'sessions' => 'The login session was successfully reset. You will need to login again.'
        ],
        'character' => [
            'skin' => [
                'success' => 'The new skin is installed successfully!',
                'disabled' => 'The ability to change the skin is disabled.',
                'invalid_ratio' => 'Invalid image size.',
            ],
            'cloak' => [
                'success' => 'The new raincoat is installed successfully!',
                'disabled' => 'The ability to change your raincoat is disabled.',
                'invalid_ratio' => 'Invalid image size.',
            ]
        ]
    ],

    'shop' => [
        'catalog' => [
            'buy' => [
                'success' => 'Purchase is successfully completed!',
                'invalid_username' => 'Username is too short or contains invalid characters.',
                'invalid_count' => 'Invalid quantity.',
            ],
            'news' => [
                'disabled' => 'News display disabled.',
                'no_more' => 'No more news.',
            ]
        ],
        'cart' => [
            'buy' => [
                'success' => 'Purchase is successfully completed!',
                'invalid_username' => 'Username is too short or contains invalid characters.',
                'invalid_count' => 'Invalid quantity.',
            ],
            'success' => [
                'message' => 'The item has been added to the cart.',
                'btn' => 'Already in the basket',
            ],
            'full' => 'Can not add product. The basket is full.',
            'already_in' => 'The product is already in the cart.',
            'remove' => [
                'success' => 'Item is removed from the cart.',
                'fail' => 'Could not remove product from cart.'
            ]
        ]
    ],

    'payments' => [
        'fillupbalance' => [
            'invalid_sum' => 'The amount must be a positive number and must be at least :min.'
        ],
        'success' => 'The payment was successful.',
        'error' => 'Payment failed.',
        'wait' => 'The payment is processed. Please wait.'
    ],

    'request_error' => 'An error occurred while executing the request.',
    'captcha_required' => 'You have to confirm that you are not a robot.'
];
