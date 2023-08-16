<?php

namespace App\Http\Webhooks;

use Exception;
use App\Helper;
use App\Services\ChatService;
use App\Models\CloseTrade;
use App\Models\MTAccount;
use Carbon\Carbon;
use App\Models\OpenTrade;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\Support\Facades\Log;
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
        try {
            $this->chat->html(ChatService::welcome())->send();
        } catch (Exception $e) {
            Log::channel('telegram')->error($e->getMessage());
            $this->chat->html(ChatService::error())->send();
        }
    }

    public function newuser()
    {
        try {
            if (empty($this->chat->user)) {
                $telegramUser = $this->chat->user()->create([
                    'uuid' => (string) Str::uuid(),
                    'first_name' => request()['message']['from']['first_name'] ?? null,
                    'last_name' => request()['message']['from']['last_name'] ?? null,
                    'language_code' => request()['message']['from']['language_code'] ?? null,
                ]);

                $message = ChatService::createUser($telegramUser->uuid);
            } else {
                $message = ChatService::userExisted($this->chat->user->uuid);
            }

            $this->chat->html($message)->send();
        } catch (Exception $e) {
            Log::channel('telegram')->error($e->getMessage());
            $this->chat->html(ChatService::error())->send();
        }
    }

    public function myid()
    {
        try {
            $user = $this->chat->user;

            if (empty($user)) {
                $this->chat->html(ChatService::userNotFound())->send();
                return;
            }

            $this->chat->html(ChatService::showUserId($user->uuid))->send();
        } catch (Exception $e) {
            Log::channel('telegram')->error($e->getMessage());
            $this->chat->html(ChatService::error())->send();
        }
    }

    public function myaccount()
    {
        try {
            if (empty($this->chat->user)) {
                $this->chat->html(ChatService::userNotFound())->send();
                return;
            }

            $accounts = $this->chat->user->accounts;

            if ($accounts->isEmpty()) {
                $this->chat->html(ChatService::accountNotFound())->send();
                return;
            }

            if ($accounts->count() > 1) {
                $this->chat->html(ChatService::selectAccount())
                    ->keyboard(function(Keyboard $keyboard) use ($accounts) {
                        foreach($accounts as $account) {
                            $keyboard
                                ->button($account->login_id)
                                ->action('show_selected_myaccount')
                                ->param('login_id', $account->login_id);
                        }
                        return $keyboard;
                    })
                    ->send();
            } else {
                $this->chat->html(ChatService::showAccountDetails($accounts->first()))->send();
            }
        } catch (Exception $e) {
            Log::channel('telegram')->error($e->getMessage());
            $this->chat->html(ChatService::error())->send();
        }
    }

    public function newtrades()
    {
        try {
            if (empty($this->chat->user)) {
                $this->chat->html(ChatService::userNotFound())->send();
                return;
            }

            $accounts = $this->chat->user->accounts;

            if ($accounts->isEmpty()) {
                $this->chat->html(ChatService::accountNotFound())->send();
                return;
            }

            if ($accounts->count() > 1) {
                $this->chat->html(ChatService::selectAccount())
                    ->keyboard(function(Keyboard $keyboard) use ($accounts) {
                        foreach($accounts as $account) {
                            $keyboard
                                ->button($account->login_id)
                                ->action('show_selected_newtrades')
                                ->param('login_id', $account->login_id);
                        }
                        return $keyboard;
                    })
                    ->send();
            } else {
                /**
                 * !Reminder: When updating the value of $period, make sure to update the value of $period in 'show_selected_newtrades()' function as well.
                 */
                $period = 12; // in hours

                $trades = OpenTrade::where('login_id', $accounts->first()->login_id)
                    ->where('open_at', '>=', Carbon::now()->subHours($period)->toDateTimeString())
                    ->get();

                $this->chat->html(ChatService::showNewTrades($trades, $period))->send();
            }
        } catch (Exception $e) {
            Log::channel('telegram')->error($e->getMessage());
            $this->chat->html(ChatService::error())->send();
        }
    }

    public function closedtrades()
    {
        try {
            if (empty($this->chat->user)) {
                $this->chat->html(ChatService::userNotFound())->send();
                return;
            }

            $accounts = $this->chat->user->accounts;

            if ($accounts->isEmpty()) {
                $this->chat->html(ChatService::accountNotFound())->send();
                return;
            }

            if ($accounts->count() > 1) {
                $this->chat->html(ChatService::selectAccount())
                    ->keyboard(function(Keyboard $keyboard) use ($accounts) {
                        foreach($accounts as $account) {
                            $keyboard
                                ->button($account->login_id)
                                ->action('show_selected_closedtrades')
                                ->param('login_id', $account->login_id);
                        }
                        return $keyboard;
                    })
                    ->send();
            } else {
                /**
                 * !Reminder: When updating the value of $period, make sure to update the value of $period in 'show_selected_closedtrades()' function as well.
                 */
                $period = 12; // in hours
                $currency = $accounts->first()->currency;

                $trades = CloseTrade::where('login_id', $accounts->first()->login_id)
                    ->where('close_at', '>=', Carbon::now()->subHours($period)->toDateTimeString())
                    ->get();

                $this->chat->html(ChatService::showClosedTrades($trades, $period, $currency))->send();
            }
        } catch (Exception $e) {
            Log::channel('telegram')->error($e->getMessage());
            $this->chat->html(ChatService::error())->send();
        }
    }

    public function summary()
    {
        try {
            if (empty($this->chat->user)) {
                $this->chat->html(ChatService::userNotFound())->send();
                return;
            }

            $accounts = $this->chat->user->accounts;

            if ($accounts->isEmpty()) {
                $this->chat->html(ChatService::accountNotFound())->send();
                return;
            }

            if ($accounts->count() > 1) {
                $this->chat->html(ChatService::selectAccount())
                    ->keyboard(function(Keyboard $keyboard) use ($accounts) {
                        foreach($accounts as $account) {
                            $keyboard
                                ->button($account->login_id)
                                ->action('show_selected_summary')
                                ->param('login_id', $account->login_id);
                        }
                        return $keyboard;
                    })
                    ->send();
            } else {

                $account = $accounts->first();

                /**
                 * !Reminder: When updating the value of $period, make sure to update the value of $period in 'show_selected_summary()' function as well.
                 */
                $period = 12; // in hours

                // Account Details
                $this->chat->html(ChatService::showAccountDetails($account))->send();

                // New Trades
                $openTrades = OpenTrade::where('login_id', $account->login_id)
                        ->where('open_at', '>=', Carbon::now()->subHours($period)->toDateTimeString())
                        ->get();

                $this->chat->html(ChatService::showNewTrades($openTrades, $period))->send();

                // Closed Trades
                $closedTrades = CloseTrade::where('login_id', $account->login_id)
                        ->where('close_at', '>=', Carbon::now()->subHours($period)->toDateTimeString())
                        ->get();

                $this->chat->html(ChatService::showClosedTrades($closedTrades, $period, $account->currency))->send();
            }
        } catch (Exception $e) {
            Log::channel('telegram')->error($e->getMessage());
            $this->chat->html(ChatService::error())->send();
        }

    }

    /* -------------------------------------------------------------------------- */
    /*                                   Action                                   */
    /* -------------------------------------------------------------------------- */
    public function show_selected_myaccount()
    {
        try {
            $loginId = $this->data->get('login_id');

            $account = MTAccount::where('login_id', $loginId)
                ->first();

            if (empty($account)) {
                throw new Exception('MT Account not found.');
            }

            $this->chat->html(ChatService::showAccountDetails($account))->send();
        } catch (Exception $e) {
            Log::channel('telegram')->error($e->getMessage());
            $this->chat->html(ChatService::error())->send();
        }
    }

    public function show_selected_newtrades()
    {
        try {
            $loginId = $this->data->get('login_id');

            /**
             * !Reminder: When updating the value of $period, make sure to update the value of $period in 'newtrades()' function as well.
             */
            $period = 12; // in hours

            $trades = OpenTrade::where('login_id', $loginId)
                ->where('open_at', '>=', Carbon::now()->subHours($period)->toDateTimeString())
                ->get();

            $this->chat->html(ChatService::showNewTrades($trades, $period))->send();
        } catch (Exception $e) {
            Log::channel('telegram')->error($e->getMessage());
            $this->chat->html(ChatService::error())->send();
        }
    }

    public function show_selected_closedtrades()
    {
        try {
            $loginId = $this->data->get('login_id');

            $account = MTAccount::where('login_id', $loginId)
                ->first();

            if (empty($account)) {
                throw new Exception('MT Account not found.');
            }

            /**
             * !Reminder: When updating the value of $period, make sure to update the value of $period in 'closedtrades()' function as well.
             */
            $period = 12; // in hours

            $trades = CloseTrade::where('login_id', $loginId)
                ->where('close_at', '>=', Carbon::now()->subHours($period)->toDateTimeString())
                ->get();

            $this->chat->html(ChatService::showClosedTrades($trades, $period, $account->currency))->send();
        } catch (Exception $e) {
            Log::channel('telegram')->error($e->getMessage());
            $this->chat->html(ChatService::error())->send();
        }
    }

    public function show_selected_summary()
    {
        try {
            $loginId = $this->data->get('login_id');

            /**
             * !Reminder: When updating the value of $period, make sure to update the value of $period in 'summary()' function as well.
             */
            $period = 12; // in hours

            // Account Details
            $account = MTAccount::where('login_id', $loginId)->first();

            $this->chat->html(ChatService::showAccountDetails($account))->send();

            // New Trades
            $period = 12; // in hours

            $openTrades = OpenTrade::where('login_id', $account->login_id)
                ->where('open_at', '>=', Carbon::now()->subHours($period)->toDateTimeString())
                ->get();

            $this->chat->html(ChatService::showNewTrades($openTrades, $period))->send();

            // Closed Trades
            $closedTrades = CloseTrade::where('login_id', $account->login_id)
                ->where('close_at', '>=', Carbon::now()->subHours($period)->toDateTimeString())
                ->get();

            $this->chat->html(ChatService::showClosedTrades($closedTrades, $period, $account->currency))->send();
        } catch (Exception $e) {
            Log::channel('telegram')->error($e->getMessage());
            $this->chat->html(ChatService::error())->send();
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                 Overriding default behaviors ███████▒▒▒ 70%                */
    /* -------------------------------------------------------------------------- */
    protected function handleChatMessage(Stringable $text): void
    {
        $this->help();
    }

    protected function handleUnknownCommand(Stringable $text): void
    {
        if (!self::$handleUnknownCommands) {
            parent::handleUnknownCommand($text);
            return;
        }

        $this->chat->html(ChatService::unknownCommand($text))->send();
    }
}