<?php

namespace App;

class Helper {

    /* -------------------------------------------------------------------------- */
    /*                                  Messages                                  */
    /* -------------------------------------------------------------------------- */
    public static function getWelcomeMessages($commands)
    {
        $message = "I can help you create and manage Telegram bots.\n\n"
        . "You can control me by sending these commands:\n\n";

        if (!empty($commands)) {
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

    public static function getNewUserMessages($userId, $status = false)
    {
        if ($status) {
            $message = __('telegram.user.create.success') . "\n\n"
                . __('telegram.user.id') . ": <code>$userId</code>\n\n"
                . __('telegram.messages.community.new') . "\n\n"
                . __('telegram.messages.common.feel_free_to_ask');
        } else {
            $message = __('telegram.user.create.failure') . "\n\n"
                . "User ID: <code>$userId</code>\n\n"
                . __('telegram.messages.community.old') . "\n\n"
                . __('telegram.messages.common.feel_free_to_ask');
        }

        return $message;
    }

    public static function getAccountDetails($data)
    {
        // TODO: Replace the dummy data with real data.
        $message = "<b>" . __('telegram.vision_trending_turbo') . "</b>\n"
            . "2022.05.13 12:41:52\n\n"
            . __('telegram.account.balance') . ": USD 7712.88\n"
            . __('telegram.account.equity') . ": USD 7536.3\n\n"
            . __('telegram.account.margin_level') . ": 8411.76%\n"
            . __('telegram.account.highest_dd') . ": 2.29% (176.58 USD)\n"
            . __('telegram.account.floating') . ": USD -176.58\n\n"
            . __('telegram.account.total_active_pairs') . ": 6\n"
            . __('telegram.account.total_orders') . ": 12\n\n"
            . __('telegram.account.profit_today') . ": USD 12.04\n"
            . __('telegram.account.profit_all_time') . ": USD 2608.88\n\n"
            . "<a href='https://fomatictech.com/'><i>" .__('telegram.by') . " ForexSpy</i></a>"
        ;
        return $message;
    }

    public static function getNewTradesReport($data)
    {
        // TODO: Replace the dummy data with real data.
        $message = "📢 <b>" . __('telegram.trade.new_trades_in_the_past', ['period' => 720]) . "</b>\n\n"
            . strtoupper(__('telegram.buy')) . "GBPCHF @ 1.22 for 0.04 " . __('telegram.lots') . "\n"
            . strtoupper(__('telegram.sell')) . " GBPCHF @ 1.22 for 0.04 " . __('telegram.lots') . "\n"
            . strtoupper(__('telegram.sell')) . " GBPCHF @ 1.22 for 0.04 " . __('telegram.lots') . "\n"
            . strtoupper(__('telegram.buy')) . " GBPCHF @ 1.22 for 0.04 " . __('telegram.lots') . "\n"
            . strtoupper(__('telegram.buy')) . " GBPCHF @ 1.22 for 0.04 " . __('telegram.lots') . "\n\n"
            . "<a href='https://fomatictech.com/'><i>" .__('telegram.by') . " ForexSpy</i></a>"
        ;
        return $message;
    }

    public static function getClosedTradesReport($data)
    {
        // TODO: Replace the dummy data with real data.
        $message = "📢 <b>" . __('telegram.trade.closed_trades_in_the_past', ['period' => 720]) . "</b>\n\n"
            . "📈 " .strtoupper(__('telegram.buy')) . "GBPCHF (0.02 lots) @ 0.085158 - Profits: 0.62\n"
            . "📉 " . strtoupper(__('telegram.sell')) . " GBPCHF (0.02 lots) @ 0.085158 - Profits: -0.62\n"
            . "📈 " . strtoupper(__('telegram.sell')) . " GBPCHF (0.02 lots) @ 0.085158 - Profits: 0.62\n"
            . "📉 " . strtoupper(__('telegram.buy')) . " GBPCHF (0.02 lots) @ 0.085158 - Profits: -0.62\n"
            . "📈 " . strtoupper(__('telegram.buy')) . " GBPCHF (0.02 lots) @ 0.085158 - Profits: 0.62\n\n"
            . __('telegram.account.total_profits') . ": USD 20.2\n"
            . "<a href='https://fomatictech.com/'><i>" .__('telegram.by') . " ForexSpy</i></a>"
        ;
        return $message;
    }

    /* -------------------------------------------------------------------------- */
    /*                                   Others                                   */
    /* -------------------------------------------------------------------------- */
    public static function getCommandList($commands)
    {
        $commandList = [];

        foreach ($commands as $key => $category) {
            if (is_array($category)) {
                foreach ($category as $command => $description) {
                    $commandList[$command] = $description;
                }
            } else {
                $commandList[$key] = $category;
            }
        }
        return $commandList;
    }
}