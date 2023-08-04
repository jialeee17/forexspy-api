<?php

return [
    /**
     * Register commands in Telegram Bot in order to display them to the user when the "/" key is pressed
     * command_category' => ['command_name' => 'command_description']
     */
    'main' => [
        'newuser' => 'Create a new user',
    ],
    'user' => [
        'myid' => 'Get user ID',
    ],
    'reports' => [
        'account' => 'Get account details',
        'newtrades' => 'Get new trades details',
        'closedtrades' => 'Get closed trades details',
        'summary' => 'Get summary details',
    ],
];