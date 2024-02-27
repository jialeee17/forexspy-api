<?php

namespace App\WebhookHandler;

use Throwable;
use App\Models\Trade;
use App\Models\TelegraphChat;
use Illuminate\Support\Facades\Log;
use App\Services\ChatMessageService;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWebhook extends SpatieProcessWebhookJob
{
    public function handle()
    {
        $webhookCall = json_decode($this->webhookCall);
        $data = $webhookCall->payload;
        $event = $data->event ?? null;
        $userUuid = $data->forexspy_user_uuid ?? null;
        $mtAccount = $data->mt_account ?? null;

        switch ($event) {
            case 'trade-history-received':
                $this->notifyAccountDetails($mtAccount, $userUuid);
                break;
            case 'new-trade-received':
                $this->notifyNewTrades($userUuid);
                break;
        }
    }

    private function notifyAccountDetails($mtAccount, $userUuid)
    {
        $chat = TelegraphChat::where('user_uuid', $userUuid)->firstOrFail();
        $chat->html(ChatMessageService::showAccountDetails($mtAccount))->send();
    }

    private function notifyNewTrades($userUuid)
    {
        $openTrades = [];
        $openTradeIds = [];
        $closedTrades = [];
        $closedTradeIds = [];
        $trades = Trade::openNotifNotSent()->orWhere->closedNotifNotSent()->get();
        $chat = TelegraphChat::where('user_uuid', $userUuid)->firstOrFail();

        foreach ($trades as $trade) {
            if ($trade->status === 'open') {
                $openTrades[] = $trade;
                $openTradeIds[] = $trade->ticket;
            } else {
                $closedTrades[] = $trade;
                $closedTradeIds[] = $trade->ticket;

                // Trades that are already closed but is not yet notified when it's opened.
                // This happens when the trade was opened and closed immediately.
                if (!$trade->open_notif_sent) {
                    $openTrades[] = $trade;
                    $openTradeIds[] = $trade->ticket;
                }
            }
        }

        // Update Notification Status
        if ($openTradeIds) {
            Trade::whereIn('ticket', $openTradeIds)->update(['open_notif_sent' => true]);
        }

        if ($closedTradeIds) {
            Trade::whereIn('ticket', $closedTradeIds)->update(['closed_notif_sent' => true]);
        }

        // Send Notification
        if ($openTrades) {
            $chat->html(ChatMessageService::notifyOpenTrade($openTrades, $openTrades[0]?->account_login_id))->send();
        }

        if ($closedTrades) {
            $chat->html(ChatMessageService::notifyCloseTrade($closedTrades, $closedTrades[0]?->account_login_id))->send();
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        Log::channel('laravel-webhook')->error($exception->getMessage());
    }
}
