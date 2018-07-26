<?php

return [
    'user' => 'User',
    'username' => 'Username',
    'player' => 'Player',
    'email' => 'Email',
    'password' => 'Password',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'send' => 'Send',
    'close' => 'Close',
    'note' => 'Note',
    'add' => 'Add',
    'create' => 'Create',
    'update' => 'Update',
    'back_to_main' => 'To index page',
    'item' => [
        'type' => [
            'item' => 'Item/Block',
            'permgroup' => 'Permission group',
            'currency' => 'In-game currency',
            'region_owner' => 'Region owner',
            'region_member' => 'Region member',
            'command' => 'Command'
        ],
        'units' => [
            'item' => ':amount',
            'permgroup' => ':duration day.',
            'currency' => ':amount',
            'region' => '-',
            'command' => '-',
            'forever' => 'Forever'
        ]
    ],
    'type' => 'Type',
    'image' => 'Image',
    'actions' => 'Actions',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'table' => [
        'of' => 'of',
        'rows_per_page' => 'Elements per page'
    ],
    'skin' => 'Skin',
    'cloak' => 'Cloak',
    'choose_file' => 'Select a file',
    'unclear_docs' => 'Something is not clear? Read the <a href=":link" target="_blank">documentation</a>.',
    'server' => 'Server',
    'category' => 'Category',
    'banned' => [
        'one' => [
            'temporarily' => [
                'with_reason' => 'This user account is locked for a reason ":reason". Expire at: :until',
                'without_reason' => 'This user\'s account is banned. Expire at: :until.'
            ],
            'permanently' => [
                'with_reason' => 'This user\'s account has been permanently locked for a reason ":reason".',
                'without_reason' => 'This user\'s account is locked forever.'
            ],
        ],
        'many' => [
            'title' => 'This user\'s account is banned. Not expired bans:',
            'temporarily' => [
                'with_reason' => 'Expire at :until. Reason: ":reason".',
                'without_reason' => 'Expire at :until.'
            ],
            'permanently' => [
                'with_reason' => 'Permanently blocked with reason ":reason".',
                'without_reason' => 'Permanently blocked.'
            ],
        ]
    ],
    'forever' => 'Forever',
    'yes' => 'Yes',
    'no' => 'No',
    'invalid_format' => 'Invalid format',
    'changed' => 'Changes successfully saved.'
];
