<?php

return [
    /**
     * Register commands in Telegram Bot in order to display them to the user when the "/" key is pressed
     * command_category' => ['command_name' => 'command_description']
     */
    'main' => [
        'new_user' => 'Register a new user',
    ],
    'user' => [
        'my_id' => 'Retrieve user ID',
        'my_account' => 'Retrieve details about your account',
        'connect' => 'Connect to your ForexSpy account',
    ],
    'reports' => [
        'view_open_trades' => 'Retrieve reports on your recent open trades',
        'view_closed_trades' => 'Retrieve reports on your recent closed trades',
        'view_summary' => 'Get an overview of your account',
    ],
];