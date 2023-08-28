<?php

namespace App\Jobs;

use Exception;
use App\Models\MTAccount;
use App\Models\TelegraphChat;
use App\Services\ChatService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessAccountNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $loginId;

    /**
     * Create a new job instance.
     */
    public function __construct($loginId)
    {
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

        $account = MTAccount::where('login_id', $this->loginId)->first();

        if (empty($account)) {
            throw new Exception('Account not found.');
        }

        $account->update(['initial_summary_notified' => 1]);

        $chat->html(ChatService::showAccountDetails($account))->send();
    }
}
