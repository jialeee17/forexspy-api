<?php

namespace App\Jobs;

use Exception;
use App\Models\TelegraphChat;
use App\Services\ChatService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessCloseTradeNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $closeTrades;
    protected $loginId;

    /**
     * Create a new job instance.
     */
    public function __construct($closeTrades, $loginId)
    {
        $this->closeTrades = $closeTrades;
        $this->loginId = $loginId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $chat = TelegraphChat::whereHas('user.accounts', function ($query) {
            $query->where('login_id', $this->loginId);
        })->first();

        if (empty($chat)) {
            throw new Exception('Chat not found.');
        }

        $chat->html(ChatService::notifyCloseTrade($this->closeTrades))->send();
    }
}
