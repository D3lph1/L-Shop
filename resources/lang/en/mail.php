<?php

return [
    'forgot_password' => [
        'subject' => 'Password reset',
        'content' => 'Hello, :username!
        Someone (Maybe you) sent a request for password recovery. To reset your password, click the link below.<br>
        <a href=":link">RESET</a><br>
        If it was not you, ignore the message.<br><br>
        <p>The IP address of the device from which the request was made: :ip</p>'
    ],
    'test' => [
        'subject' => 'Test message',
        'content' => 'This test message was sent from the site: :site in order to perform the verification.'
    ],
    'user_activation' => [
        'subject' => 'Account activation',
        'content' => 'Hello, :username!
        We are glad to see a new user who has become a part of our project.
        To complete the registration procedure, you need to click on the link:
        <a href=":link">CLICK...</a>'
    ],
];
