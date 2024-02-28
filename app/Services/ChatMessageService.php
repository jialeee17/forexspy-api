<?php

namespace App\Services;

class ChatMessageService
{
    public static function welcome()
    {
        $commands = config('botcommands');

        $message = str_replace(':name', env('APP_NAME'), __('telegram.welcome')) . "\n\n"
            . str_replace(':name', env('APP_NAME'), __('telegram.intro_opening'));

        if (!empty($commands)) {
            $message .= "\n\n";

            foreach ($commands as $key => $category) {
                $message .= "<b>" . ucfirst($key) . "</b>\n";

                if (is_array($category)) {
                    foreach ($category as $command => $description) {
                        $message .= "/$command - $description\n";
                    }
                }

                $message .= "\n";
            }
        }

        return $message;
    }

    public static function userRegistrationSuccess($id)
    {
        $message = str_replace(':name', env('APP_NAME'), __('telegram.user_registration_success')) . "\n\n"
            . __('telegram.user_id') . ": <code>$id</code>";

        return $message;
    }

    public static function showUserId($id)
    {
        $replace = "<code>$id</code>";
        $message = str_replace(':id', $replace, __('telegram.show_user_id'));

        return $message;
    }

    public static function accountDetails($account)
    {
        $currency = $account->currency;
        $date = date('Y-m-d H:i:s');

        $message = "<b>📊 Account Details:</b>\n\n"
            . "$date\n\n"
            . __('telegram.account_id') . ": {$account->login_id}\n"
            . __('telegram.account_balance') . ": $currency {$account->balance}\n"
            . __('telegram.account_equity') . ": $currency {$account->equity}\n\n"
            . __('telegram.margin_level') . ": {$account->margin_level}%\n"
            . __('telegram.highest_dd') . ": {$account->highest_drawdown_percentage}% ({$account->highest_drawdown_amount} $currency)\n"
            . __('telegram.floating') . ": $currency {$account->profit}\n\n"
            . __('telegram.total_active_pairs') . ": {$account->active_pairs}\n"
            . __('telegram.total_orders') . ": {$account->active_orders}\n\n"
            . __('telegram.profit_today') . ": $currency {$account->profit_today}\n"
            . __('telegram.profit_all_time') . ": $currency {$account->profit_all_time}\n\n";
            // . "<a href='" . env('APP_URL') . "'><i>" . __('telegram.by') . " " . env('APP_NAME') . "</i></a>";

        return $message;
    }

    // public static function existingUser($id)
    // {
    //     $message = __('telegram.message.account_existed') . "\n\n"
    //         . __('telegram.user_id') . ": <code>$id</code>\n\n"
    //         . __('telegram.message.old_community') . "\n\n"
    //         . __('telegram.message.feel_free_to_ask');

    //     return $message;
    // }

    public static function connectionExist()
    {
        return str_replace(':name', env('APP_NAME'), __('telegram.connection_exist'));
    }

    public static function pastOpenTrades($trades, $period)
    {
        if ($trades->isNotEmpty()) {
            $message = "<b>📈 Recent Open Trades Summary</b>\n\n";

            foreach ($trades as $trade) {
                $type = strtoupper(__('telegram.' . $trade->type));
                $symbol = strtoupper($trade->symbol);
                $openPrice = $trade->open_price;
                $lots = $trade->lots;

                $message .= "$type $symbol @ $openPrice for $lots " . __('telegram.lots') . "\n";
            }

            // $message .= "\n <a href='" . env('APP_URL') . "'><i>" . __('telegram.by') . " " . env('APP_NAME') . "</i></a>";
        } else {
            $message = __('telegram.trade.new_trade_not_found');
        }

        return $message;
    }

    public static function pastClosedTrades($trades, $period, $currency)
    {
        if ($trades->isNotEmpty()) {
            $totalProfit = 0;

            $message = "<b>📉 Recent Closed Trades Summary</b>\n\n";

            foreach ($trades as $trade) {
                $type = strtoupper(__('telegram.' . $trade->type));
                $symbol = strtoupper($trade->symbol);
                $lots = $trade->lots;
                $closedPrice = $trade->close_price;
                $profit = $trade->take_profit;

                if ($trade->take_profit > 0) {
                    $emoji = '💵';
                } elseif ($trade->take_profit == 0) {
                    $emoji = '➖';
                } else {
                    $emoji = '💸';
                }

                $message .= "$emoji $type $symbol ($lots " . __('telegram.lots') . ") @ $closedPrice - " . __('telegram.profits') . ": $profit\n";

                $totalProfit += $trade->take_profit;
            }

            $message .= "\n" . __('telegram.total_profits') . ": $currency $totalProfit\n\n";
                // . "<a href='" . env('APP_URL') . "'><i>" . __('telegram.by') . " " . env('APP_NAME') . "</i></a>";
        } else {
            $message = __('telegram.trade.close_trade_not_found');
        }

        return $message;
    }

    public static function newOpenTrades($trades, $loginId)
    {
        $message = "<b>" . __('telegram.new_open_trades') . "</b>\n\n"
            . __('telegram.account_id') . ": $loginId\n\n";

        foreach ($trades as $trade) {
            $type = strtoupper(__('telegram.' . $trade->type));
            $symbol = strtoupper($trade->symbol);
            $openPrice = $trade->open_price;
            $lots = $trade->lots;
            $openAt = $trade->open_at;

            $message .= "$type $symbol @ $openPrice for $lots " . __('telegram.lots') . " (" . __('telegram.open_time') . ": $openAt)\n";
        }

        // $message .= "\n <a href='" . env('APP_URL') . "'><i>" . __('telegram.by') . " " . env('APP_NAME') . "</i></a>";
        return $message;
    }

    public static function newClosedTrades($trades, $loginId)
    {
        $message = "<b>" . __('telegram.new_closed_trades') . "</b>\n\n"
            . __('telegram.account_id') . ": $loginId\n\n";

        foreach ($trades as $trade) {
            $type = strtoupper(__('telegram.' . $trade->type));
            $symbol = strtoupper($trade->symbol);
            $lots = $trade->lots;
            $closedPrice = $trade->close_price;
            $profit = $trade->take_profit;
            $closedAt = $trade->close_at;

            if ($trade->take_profit > 0) {
                $emoji = '💵';
            } elseif ($trade->take_profit == 0) {
                $emoji = '➖';
            } else {
                $emoji = '💸';
            }

            $message .= "$emoji $type $symbol ($lots " . __('telegram.lots') . ") @ $closedPrice - " . __('telegram.profits') . ": $profit (" . __('telegram.close_time') . ": $closedAt)\n";
        }

        // $message .= "\n <a href='" . env('APP_URL') . "'><i>" . __('telegram.by') . " " . env('APP_NAME') . "</i></a>";
        return $message;
    }

    public static function unknownCommand()
    {
        return __('telegram.unknown_command');
    }
}
