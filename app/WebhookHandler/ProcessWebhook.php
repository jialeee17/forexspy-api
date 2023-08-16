<?php

namespace App\WebhookHandler;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessOpenTradeNotification;
use App\Jobs\ProcessCloseTradeNotification;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWebhook extends SpatieProcessWebhookJob
{
    public function handle()
    {
        try {
            $webhook = json_decode($this->webhookCall, true); // contains an instance of `WebhookCall`

            $data = $webhook['payload'];

            $loginId = $data['login_id'];
            $openTrades = $data['new_open_trades'];
            $closeTrades = $data['new_close_trades'];

            if (empty($loginId)) {
                throw new Exception('Login ID not found.');
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
