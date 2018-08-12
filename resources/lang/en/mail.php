<?php

return [
    'auth' => [
        'confirmation' => [
            'subject' => 'Account activation',
            'hello' => 'Hello :user!',
            'description' => 'We are glad to see a new user who became part of our project.<br>To complete the registration procedure, you need to follow the link below.',
            'complete' => 'Complete registration'
        ],
        'reminder' => [
            'subject' => 'Password reset',
            'hello' => 'Hello :user!',
            'description' => 'Someone (perhaps you) sent a request for password recovery. To reset your password, click the link below.',
            'reset' => 'Reset the password',
            'warning' => 'If you did not send a request, please ignore this message.'
        ]
    ],
    'test' => [
        'subject' => 'Test email',
        'content' => 'This email was sent to verify how the email function works. If you read this, then the dispatch functions correctly.'
    ],
    'team' => ':name team'
];
