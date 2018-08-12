<?php

return [
    'frontend' => [
        'auth' => [
            'login' => [
                'invalid_credentials' => 'User with this credentials not found.',
                'welcome' => 'Welcome, :username!',
                'not_activated' => 'User not activated.',
                'too_many_attempts' => 'You have made too many failed attempts at authentication. Sign-in is temporarily disabled. It remains :remaining sec.'
            ],
            'register' => [
                'username_already_exist' => 'User with this username already exists.',
                'email_already_exist' => 'User with this email already exists.',
                'success' => 'Registration successfully completed. Now you can sign in to your account.'
            ],
            'logout' => [
                'success' => 'You left the account.'
            ],
            'password' => [
                'forgot' => [
                    'success' => 'An email with instructions on resetting your password has been sent to your email.',
                    'user_not_found' => 'User with this email not found.'
                ],
                'reset' => [
                    'invalid_code' => 'The password reset code does not exist or expired.',
                    'success' => 'Password changed successfully.'
                ]
            ],
            'activation' => [
                'success' => 'Your account has been successfully activated!',
                'fail' => 'The activation code is invalid or expired.',
                'already' => 'This account already activated.',
                'repeat' => 'A second activation request was sent.',
                'user_not_found' => 'Failed to resubmit request: user with this email address not found or already activated.'
            ]
        ],
        'shop' => [
            'catalog' => [
                'put_in_cart' => 'The product has been added to the cart.',
                'product_not_found' => 'Product not found.',
                'purchase' => [
                    'success' => 'The purchase was successful.',
                    'invalid_amount' => 'The purchase of such quantities is impossible.',
                    'distribution_failed' => 'The purchase is complete, but an attempt to deliver the product failed. Issue the products manually or contact the project administration.'
                ]
            ],
            'cart' => [
                'remove' => [
                    'success' => 'Item is removed from the cart.',
                    'fail' => 'It was not possible to remove the item from the shopping cart.'
                ],
                'purchase' => [
                    'server_not_found' => 'The server does not exist.'
                ]
            ],
            'payment' => [
                'wait' => 'The payment is processed. Please wait.',
                'success' => 'The payment was successful.',
                'fail' => 'Payment failed.',
            ]
        ],
        'profile' => [
            'skin' => [
                'success' => 'Skin is successfully installed!',
                'disabled' => 'The ability to install skins is disabled.',
                'invalid_ratio' => 'Invalid aspect ratio of the image.',
                'invalid_resolution' => 'Invalid image resolution.',
                'delete' => [
                    'success' => 'Skin removed.',
                    'fail' => 'Could not remove the skin.'
                ]
            ],
            'cloak' => [
                'success' => 'The cloak was successfully installed!',
                'disabled' => 'Ability to install cloaks is disabled.',
                'invalid_ratio' => 'Invalid aspect ratio of the image.',
                'invalid_resolution' => 'Invalid image resolution.',
                'delete' => [
                    'success' => 'The cloak is removed.',
                    'fail' => 'Could not remove the raincoat.'
                ]
            ],
            'settings' => [
                'password_change' => [
                    'success' => 'Password changed successfully.'
                ],
                'reset_sessions' => [
                    'success' => 'Login session was reset. You need to reauthorize.'
                ]
            ],
            'cart' => [
                'distribution' => [
                    'wait' => 'The action is processed. In order to find out the result, check your in-game
                    inventory or refresh the page.',
                    'not_found' => 'Could not get the item to the player. Perhaps the extradition has already been made.',
                    'failure' => 'We could not issue the goods. Please try again later or contact the project administration.'
                ]
            ]
        ]
    ],
    'admin' => [
        'control' => [
            'optimization' => [
                'reset_app_cache_successfully' => 'The application cache has been successfully reset.'
            ]
        ],
        'servers' => [
            'switch' => [
                'server_not_found' => 'Failed to switch: server could not be found.',
                'enabled' => 'The server was enabled.',
                'disabled' => 'The server was disabled.',
            ],
            'add' => [
                'success' => 'The server was created successfully.',
                'distributor_not_found' => 'Could not create the server: this distributor is not registered in the system.'
            ],
            'edit' => [
                'success' => 'The server has been successfully changed.',
                'server_not_found' => 'Editing failed: server could not be found.',
                'category_not_found' => 'Editing failed: category not found.',
                'distributor_not_found' => 'Failed to change the server: this distributor is not registered in the system.'
            ],
            'delete' => [
                'success' => 'The server was deleted.',
                'not_found' => 'Failed to delete: server could not be found.'
            ]
        ],
        'products' => [
            'add' => [
                'success' => 'The product was successfully created.',
                'item_not_found' => 'There was a problem adding the product: item does not exist.',
                'category_not_found' => 'There was a problem adding the product: the category does not exist.',
            ],
            'edit' => [
                'success' => 'Product successfully changed.',
                'product_not_found' => 'Editing failed: product does not exist.',
                'item_not_found' => 'Editing failed: item does not exist.',
                'category_not_found' => 'Editing failed: category does not exist.',
            ],
            'delete' => [
                'success' => 'Product was deleted.',
                'not_found' => 'Failed to delete: product does not exist.'
            ]
        ],
        'items' => [
            'add' => [
                'success' => 'The item was successfully created.'
            ],
            'edit' => [
                'success' => 'The item has been successfully changed.',
                'not_found' => 'Editing failed: item does not exist.'
            ],
            'list' => [
                'delete' => [
                    'success' => 'Предмет был удалён.',
                    'not_found' => 'The item was deleted.'
                ]
            ]
        ],
        'news' => [
            'add' => [
                'success' => 'The news was successfully published.'
            ],
            'edit' => [
                'success' => 'The news was successfully changed.',
                'not_found' => 'News with id :id not found.'
            ],
            'list' => [
                'delete' => [
                    'success' => 'The news was deleted.',
                    'not_found' => 'Failed to delete: the news could not be found.'
                ]
            ]
        ],
        'pages' => [
            'add' => [
                'success' => 'Static page was successfully created.',
                'already_exists' => 'Failed to add static page: page with this address already exists.'
            ],
            'edit' => [
                'success' => 'Static page has been successfully updated.',
                'not_found' => 'Failed to update static page: page not found.'
            ],
            'list' => [
                'delete' => [
                    'success' => 'The page has been deleted.',
                    'not_found' => 'Failed to delete static page: page not found.'
                ]
            ]
        ],
        'users' => [
            'edit' => [
                'success' => 'User successfully updated.',
                'user_not_found' => 'Editing failed: user not found.',
                'username_already_exists' => 'A user with this username already exists.',
                'email_already_exists' => 'A user with this email address already exists.',
                'ban' => [
                    'add' => [
                        'success' => 'The user is blocked.',
                        'user_not_found' => 'The user could not be blocked: the user was not found.'
                    ],
                    'delete' => [
                        'success' => 'The ban is deleted.',
                        'not_found' => 'The ban was not found.'
                    ]
                ]
            ],
            'list' => [
                'delete' => [
                    'success' => 'User successfully deleted.',
                    'user_not_found' => 'Failed to delete: user not found.'
                ]
            ],
            'permissions' => [
                'not_found' => 'Permission not found.',
                'already_exists_with_name' => 'Permission with name ":name" already exists.',
                'successfully_created' => 'Permission successfully created.',
                'successfully_updated' => 'Permission successfully updated.',
                'successfully_deleted' => 'Permission successfully deleted.'
            ],
            'roles' => [
                'not_found' => 'Role not found.',
                'already_exists_with_name' => 'Role with name ":name" already exists.',
                'successfully_created' => 'Role successfully created.',
                'successfully_updated' => 'Role successfully updated.',
                'successfully_deleted' => 'Role successfully deleted.',
                'permission_not_found_with_name' => 'Permission with \":name\" not found.'
            ]
        ],
        'statistic' => [
            'purchases' => [
                'complete' => [
                    'success' => 'The purchase was successfully completed, the content was issued to the user.',
                    'already_completed' => 'The purchase could not be completed: it has already been completed.'
                ]
            ]
        ]
    ],
    'api' => [
        'auth' => [
            'sashok724sV3Launcher' => [
                'disabled' => 'Feature disabled.',
                'ip_not_in_whitelist' => 'The request could not be executed from this IP.',
                'banned' => 'This user is blocked.',
                'throttling' => 'Many unsuccessful attempts, try after :cooldown sec.'
            ]
        ]
    ],
    'request_error' => [
        'title' => 'An error occurred while performing the request.',
        'notify' => 'We recommend informing the administration of this resource.',
        'main' => 'To index page',
        'back' => 'Back',
    ],
    'only_for_auth' => 'In order to perform this action, you must log in.',
    'user_not_found' => 'User is not found.',
    'only_for_guests' => 'Only for guests.',
    'captcha_required' => 'You have to confirm that you are not a robot.',
    'forbidden' => 'Forbidden.',
    'no_rights' => 'You do not have sufficient permissions to perform this action.'
];
