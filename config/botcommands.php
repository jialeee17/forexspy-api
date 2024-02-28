<?php

return [
    /**
     * Register commands in Telegram Bot in order to display them to the user when the "/" key is pressed
     * command_category' => ['command_name' => 'command_description']
     */
    'main' => [
        'new_user' => 'Register a new user',
    ],
    'users' => [
        'my_id' => 'Retrieve user ID',
        'my_account' => 'Retrieve details about your account',
        'connect' => 'Connect to your ForexSpy account',
    ],
    'report' => [
        'view_open_trades' => 'Retrieve reports on your recent open trades',
        'view_closed_trades' => 'Retrieve reports on your recent closed trades',
        'view_summary' => 'Get an overview of your account',
    ],
    'trades' => [
        'close_all_trades' => 'Close all active trades',
        'disable_auto_trading' => 'Disable auto trading feature',
    ],
];