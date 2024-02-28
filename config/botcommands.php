<?php

return [
    /**
     * Register commands in Telegram Bot in order to display them to the user when the "/" key is pressed
     * command_category' => ['command_name' => 'command_description']
     */
    'users' => [
        'new_user' => 'Register a new user',
        'my_id' => 'Retrieve user ID',
        'my_account' => 'Retrieve details about your MetaTrader account',
        'connect' => 'Connect to your ForexSpy account',
    ],
    'reports' => [
        'view_open_trades' => 'View your recent open trades',
        'view_closed_trades' => 'View your recent closed trades',
        'view_summary' => 'View your MetaTrader account summary',
    ],
    'actions' => [
        'close_all_trades' => 'Close all active trades',
        'disable_auto_trading' => 'Disable auto trading feature',
    ],
];