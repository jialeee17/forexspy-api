<?php

namespace App\Console\Commands;

use App\Models\TelegraphBot;
use Illuminate\Console\Command;
use App\Helper;

class RegisterBotCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegraph:register-commands
                            {bot-token : The Telegram Bot token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register Telegraph Bot commands';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = $this->argument('bot-token');

        $bot = TelegraphBot::where('token', $token)->first();

        if (!$bot) {
            return;
        }

        $commands = config('botcommands');

        $bot->unregisterCommands()->send();
        $bot->registerCommands(Helper::getCommandList($commands))->send();
    }
}
