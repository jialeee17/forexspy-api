<?php

return [
    /**
     * Register commands in Telegram Bot in order to display them to the user when the "/" key is pressed
     * command_category' => ['command_name' => 'command_description']
     */
    'main' => [
        'newuser' => 'Register a new user',
    ],
    'user' => [
        'myid' => 'Retrieve user ID',
        'myaccount' => 'Retrieve details about your account',
    ],
    'reports' => [
        'newtrades' => 'Retrieve reports on your recent new trades',
        'closedtrades' => 'Retrieve reports on your recent closed trades',
        'summary' => 'Get an overview of your account',
    ],
];