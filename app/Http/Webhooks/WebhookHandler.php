<?php

namespace App\Http\Webhooks;

use Illuminate\Support\Str;
use App\Models\TelegramUser;
use App\Helper;
use App\Models\TelegraphBot;
use App\Models\TelegraphChat;
use Illuminate\Support\Stringable;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

class WebhookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    protected static $handleUnknownCommands = true;

    public function start()
    {
        $this->help();
    }

    public function help()
    {
        $commands = config('botcommands', []);

        $this->bot->registerCommands(Helper::getCommandList($commands))->send();

        $message = Helper::getWelcomeMessages($commands);

        $this->chat->html($message)->send();
    }

    public function newuser()
    {
        $message = '';

        if (TelegramUser::where('telegraph_chat_id', $this->chat->id)->doesntExist()) {
            $telegramUser = TelegramUser::create([
                'uuid' => (string) Str::uuid(),
                'telegraph_chat_id' => $this->chat->id,
                'first_name' => request()->message['from']['first_name'] ?? null,
                'last_name' => request()->message['from']['last_name'] ?? null,
                'language_code' => request()->message['from']['language_code'] ?? '',
            ]);

            $message = Helper::getNewUserMessages($telegramUser->uuid, true);

        } else {
            $message = Helper::getNewUserMessages($this->chat->user->uuid, false);
        }

        $this->chat->html($message)->send();
    }

    public function myid()
    {
        $message = "";

        if ($this->chat->user()->exists()) {
            $message = __('telegram.here_it_is') . ": <code>{$this->chat->user->uuid}</code>";
        } else {
            $message = __('telegram.user.not_found');
        }

        $this->chat->html($message)->send();
    }

    public function account()
    {
        // TODO: Retrieve data from db.
        $data = '';

        $this->chat->html(Helper::getAccountDetails($data))->send();
    }

    public function newtrades()
    {
        // TODO: Retrieve data from db.
        $data = '';

        $this->chat->html(Helper::getNewTradesReport($data))->send();
    }

    public function closedtrades()
    {
        // TODO: Retrieve data from db.
        $data = '';

        $this->chat->html(Helper::getClosedTradesReport($data))->send();
    }

    public function summary()
    {
        // TODO: Retrieve account details, active and closed trade history from db.
        $data = '';

        $this->chat->html(Helper::getAccountDetails($data))->send();
        $this->chat->html(Helper::getNewTradesReport($data))->send();
        $this->chat->html(Helper::getClosedTradesReport($data))->send();
    }

    /* -------------------------------------------------------------------------- */
    /*                 Overriding default behaviors ███████▒▒▒ 70%                */
    /* -------------------------------------------------------------------------- */
    protected function handleChatMessage(Stringable $text): void
    {
        $this->start();
    }

    protected function handleUnknownCommand(Stringable $text): void
    {
        if (!self::$handleUnknownCommands) {
            parent::handleUnknownCommand($text);
            return;
        }

        $this->chat->html("Sorry, I can't understand your command: $text")->send();
    }
}