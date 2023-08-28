<?php

namespace App\WebhookHandler;

use App\Jobs\ProcessAccountNotification;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessOpenTradeNotification;
use App\Jobs\ProcessCloseTradeNotification;
use App\Models\MTAccount;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWebhook extends SpatieProcessWebhookJob
{
    public function handle()
    {
        try {
            $webhook = json_decode($this->webhookCall, true); // contains an instance of `WebhookCall`

            $data = $webhook['payload'];

            $loginId = $data['login_id'] ?? null;
            $openTrades = $data['new_open_trades'] ?? null;
            $closeTrades = $data['new_close_trades'] ?? null;
            $isHistorical = $data['is_historical'] ?? null;

            $account = MTAccount::where('login_id', $loginId)->first();

            if (!$account) {
                throw new Exception('Account not found.');
            }

            if ($isHistorical && !$account->initial_summary_notified) {
                ProcessAccountNotification::dispatch($loginId);
            }

            if (!empty($openTrades)) {
                ProcessOpenTradeNotification::dispatch($openTrades, $loginId);
            }

            if (!empty($closeTrades)) {
                ProcessCloseTradeNotification::dispatch($closeTrades, $loginId);
            }

        } catch (Exception $e) {
            Log::channel('webhook')->error($e->getMessage());
        }
    }
}
