<?php

namespace App\Services;

class ChatMessageService
{
    public static function createUser($id)
    {
        $message = __('telegram.message.account_create_success') . "\n\n"
            . __('telegram.user.id') . ": <code>$id</code>\n\n"
            . __('telegram.message.new_community') . "\n\n"
            . __('telegram.message.feel_free_to_ask');

        return $message;
    }

    public static function showUserId($id)
    {
        $message = __('telegram.here_it_is') . ": <code>$id</code>";

        return $message;
    }

    public static function showAccountDetails($account)
    {
        $currency = $account->currency;

        $message = "<b>" . config('app.name') . "</b>\n"
            . date('Y-m-d H:i:s') . "\n\n"
            . __('telegram.account.id') . ": {$account->login_id}\n"
            . __('telegram.account.balance') . ": $currency {$account->balance}\n"
            . __('telegram.account.equity') . ": $currency {$account->equity}\n\n"
            . __('telegram.margin_level') . ": {$account->margin_level}%\n"
            . __('telegram.highest_dd') . ": {$account->highest_drawdown_percentage}% ({$account->highest_drawdown_amount} $currency)\n"
            . __('telegram.floating') . ": $currency {$account->profit}\n\n"
            . __('telegram.total_active_pairs') . ": {$account->active_pairs}\n"
            . __('telegram.total_orders') . ": {$account->active_orders}\n\n"
            . __('telegram.profit_today') . ": $currency {$account->profit_today}\n"
            . __('telegram.profit_all_time') . ": $currency {$account->profit_all_time}\n\n"
            . "<a href='" . config('app.url') ."'><i>" . __('telegram.by') . " " . config('app.name') . "</i></a>"
        ;

        return $message;
    }

    public static function showNewTrades($trades, $period)
    {
        if ($trades->isNotEmpty()) {
            $message = "📢 <b>" . __('telegram.trade.past_new_trades', ['period' => $period]) . "</b>\n\n";

            foreach ($trades as $trade) {
                $message .= strtoupper(__('telegram.' . $trade->type)) . " " . strtoupper($trade->symbol) . " @ {$trade->open_price} for {$trade->lots} " . __('telegram.lots') . "\n";
            }

            $message .= "\n <a href='" . config('app.url') ."'><i>" . __('telegram.by') . " " . config('app.name') . "</i></a>";
        } else {
            $message = __('telegram.trade.new_trade_not_found');
        }

        return $message;
    }

    public static function showClosedTrades($trades, $period, $currency)
    {
        if ($trades->isNotEmpty()) {
            $totalProfit = 0;

            $message = "📢 <b>" . __('telegram.trade.past_closed_trades', ['period' => $period]) . "</b>\n\n";

            foreach ($trades as $trade) {
                $emoji = $trade->take_profit > 0 ? '📈' : '📉';

                $message .= $emoji . " " . strtoupper(__('telegram.' . $trade->type)) . " " . strtoupper($trade->symbol) . " ({$trade->lots} " . __('telegram.lots') . ") @ {$trade->close_price} - " . __('telegram.profits') . ": {$trade->take_profit}\n";

                $totalProfit += $trade->take_profit;
            }

            $message .="\n" . __('telegram.total_profits') . ": {$totalProfit} {$currency}\n"
                . "<a href='" . config('app.url') ."'><i>" . __('telegram.by') . " " . config('app.name') . "</i></a>";
        ;
        } else {
            $message = __('telegram.trade.close_trade_not_found');
        }

        return $message;
    }

    public static function notifyOpenTrade($trades, $loginId)
    {
        $message = "✅ <b>" . __('telegram.message.open_trade_success') . "</b>\n\n"
            . __('telegram.account.id') . ": $loginId\n\n";

        foreach ($trades as $trade) {
            $message .= strtoupper(__('telegram.' . $trade->type)) . " " . strtoupper($trade->symbol) . " @ {$trade->open_price} for {$trade->lots} " . __('telegram.lots') . " (" . __('telegram.open_time') . ": {$trade->open_at})\n";
        }

        $message .= "\n <a href='" . config('app.url') ."'><i>" . __('telegram.by') . " " . config('app.name') . "</i></a>";

        return $message;
    }

    public static function notifyCloseTrade($trades, $loginId)
    {
        $message = "✅ <b>" . __('telegram.message.close_trade_success') . "</b>\n\n"
            . __('telegram.account.id') . ": $loginId\n\n";

        foreach ($trades as $trade) {
            $emoji = $trade->take_profit > 0 ? '📈' : '📉';

            $message .= $emoji . " " . strtoupper(__('telegram.' . $trade->type)) . " " . strtoupper($trade->symbol) . " ({$trade->lots} " . __('telegram.lots') . ") @ {$trade->close_price} - " . __('telegram.profits') . ": {$trade->take_profit} (" . __('telegram.close_time') . ": {$trade->close_at})\n";
        }

        $message .= "\n <a href='" . config('app.url') ."'><i>" . __('telegram.by') . " " . config('app.name') . "</i></a>";

        return $message;
    }

    /* -------------------------------------------------------------------------- */
    /*                                   Common                                   */
    /* -------------------------------------------------------------------------- */
    public static function welcome()
    {
        $commands = config('botcommands');

        $message = __('telegram.message.welcome_1') . "\n\n"
            . __('telegram.message.welcome_2');

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

    public static function existingUser($id)
    {
        $message = __('telegram.message.account_existed') . "\n\n"
            . __('telegram.user.id') . ": <code>$id</code>\n\n"
            . __('telegram.message.old_community') . "\n\n"
            . __('telegram.message.feel_free_to_ask');

        return $message;
    }

    public static function selectAccount()
    {
        $message = __('telegram.message.select_account');

        return $message;
    }

    public static function unknownCommand($command)
    {
        $message = __('telegram.message.unknown_command', ['command' => $command]);

        return $message;
    }
}