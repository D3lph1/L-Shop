<?php

return [
    'user' => [
        'create' => [
            'greeting' => 'Create a new user.',
            'username' => 'Enter username',
            'email' => 'Enter the email address of the user',
            'password' => 'Enter the user password',
            'password_confirmation' => 'Confirm password',
            'password_confirmation_error' => 'Passwords must match.',
            'activate' => 'Activate the user.',
            'roles' => 'Select the roles that the user will have ',
            'success' => 'The user was created successfully.'
        ],
        'delete' => [
            'title' => 'Deleting a user',
            'description' => 'This operation permanently removes all associated components from the user\'s system.',
            'confirm' => 'Continue?',
            'canceled' => 'The deletion was canceled.',
            'success' => 'User deleted successfully.'
        ],
        'roles' => [
            'attach' => [
                'user_not_found' => 'User with username ":username" not found.',
                'role_not_found' => 'Role with name ":name" not found.',
                'already_has_role' => 'User already has a role with name ":name".',
                'success' => 'User roles have been successfully updated.'
            ],
            'detach' => [
                'role_not_found' => 'A role with the name ":name" was not found by this user.'
            ],
            'list' => [
                'title' => 'User :username roles:',
                'table' => [
                    'id' => 'ID',
                    'name' => 'Role name'
                ]
            ]
        ]
    ],
    'purchase' => [
        'complete' => [
            'not_found' => 'A purchase with a given identifier was not found.',
            'already_completed' => 'This purchase has already been completed.',
            'success' => 'The purchase was successfully completed, the content was issued to the user.',
        ]
    ],
    'rcon' => [
        'welcome' => 'Welcome to the interactive Rcon-console.',
        'select_server' => 'To get started, select the server you want to connect to',
        'connecting' => 'Establishing a connection to the server ...',
        'connected' => 'Connection established!',
        'error' => 'Could not connect to the server.',
        'input' => 'Enter the command'
    ],
    'db' => [
        'transfer' => [
            'welcome' => 'You are greeted by the L-Shop Database Transfer Wizard. It will help to adapt the data stored in the database of the old version of L-Shop to the new version.',
            'select_version' => 'Select the version you want to convert from',
            'wait_transfer' => 'Please wait, transfer is in progress ...',
            'success_transfer' => 'Transfer was successful!',
            'wait_seeding' => 'Please wait, loading system data into the database ...',
            'success_seeding' => 'Seeding was successful!',
        ]
    ]
];
