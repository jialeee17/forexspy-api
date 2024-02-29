<?php

namespace App\Http\Webhooks;

use Exception;
use Throwable;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Trade;
use App\Models\MTAccount;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Stringable;
use App\Repositories\UserRepository;
use App\Services\ChatMessageService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WebhookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    // Add all the data keys inside the storage
    const STORAGE_DATA_LIST = [
        'registration_step',
        'registration_name',
        'registration_username',
        'registration_email',
        'process_acc_connection',
    ];

    protected static $handleUnknownCommands = true;

    private $userRepository;

    private $period = 12; // Default time period in hours for viewing past trade history

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /* -------------------------------------------------------------------------- */
    /*                            Handle Chat Commands                            */
    /* -------------------------------------------------------------------------- */
    public function start()
    {
        $this->chat->html(ChatMessageService::welcome())->send();
    }

    public function help()
    {
        $this->start();
    }

    public function new_user()
    {
        // Middlewares
        $this->ensureStorageIsClear(self::STORAGE_DATA_LIST);

        // Handle User Registration
        $this->chat->storage()->set('registration_step', 1);
        $this->chat->html('Please enter your name.')->send();
    }

    public function my_id()
    {
        // Middlewares
        $this->ensureUserAccountIsExist();
        $this->ensureStorageIsClear(self::STORAGE_DATA_LIST);

        $this->chat->html(ChatMessageService::showUserId($this->chat->user_uuid))->send();
    }

    public function my_account()
    {
        // Middlewares
        $this->ensureUserAccountIsExist();
        $this->ensureMTAccountIsExist();
        $this->ensureStorageIsClear(self::STORAGE_DATA_LIST);

        $accounts = $this->chat->user?->mtAccounts;

        if ($accounts->count() > 1) {
            $this->chat->html('Please select the MetaTrader account you want to view:')
                ->keyboard(function (Keyboard $keyboard) use ($accounts) {
                    foreach ($accounts as $account) {
                        $keyboard
                            ->button($account->login_id)
                            ->action('view_selected_acc_details')
                            ->param('login_id', $account->login_id);
                    }
                    return $keyboard;
                })
                ->send();
        } else {
            $this->chat->html(ChatMessageService::accountDetails($accounts->first()))->send();
        }
    }

    public function connect()
    {
        // Middlewares
        $this->ensureStorageIsClear(self::STORAGE_DATA_LIST);

        if ($this->chat->user) {
            $message = ChatMessageService::connectionExist();
        } else {
            $message = 'Please enter your user ID.';
            $this->chat->storage()->set('process_acc_connection', 1);
        }

        $this->chat->html($message)->send();
    }

    public function view_open_trades()
    {
        // Middlewares
        $this->ensureUserAccountIsExist();
        $this->ensureMTAccountIsExist();
        $this->ensureStorageIsClear(self::STORAGE_DATA_LIST);

        $accounts = $this->chat->user?->mtAccounts;

        if ($accounts->count() > 1) {
            $this->chat->html('Please select the MetaTrader account you want to view:')
                ->keyboard(function (Keyboard $keyboard) use ($accounts) {
                    foreach ($accounts as $account) {
                        $keyboard
                            ->button($account->login_id)
                            ->action('view_selected_acc_open_trades')
                            ->param('login_id', $account->login_id);
                    }
                    return $keyboard;
                })
                ->send();
        } else {
            // ! Sync view_selected_acc_open_trades() function when updating code here.
            $account = $accounts->first();
            $period = $this->period ?? 12;
            $now = Carbon::now();

            $trades = Trade::where('account_login_id', $account->login_id)
                ->where('open_at', '>=', $now->subHours($period)->toDateTimeString())
                ->open()
                ->get();

            $this->chat->html(ChatMessageService::recentOpenTrades($trades, $period))->send();
        }
    }

    public function view_closed_trades()
    {
        // Middlewares
        $this->ensureUserAccountIsExist();
        $this->ensureMTAccountIsExist();
        $this->ensureStorageIsClear(self::STORAGE_DATA_LIST);

        $accounts = $this->chat->user?->mtAccounts;

        if ($accounts->count() > 1) {
            $this->chat->html('Please select the MetaTrader account you want to view:')
                ->keyboard(function (Keyboard $keyboard) use ($accounts) {
                    foreach ($accounts as $account) {
                        $keyboard
                            ->button($account->login_id)
                            ->action('view_selected_acc_closed_trades')
                            ->param('login_id', $account->login_id);
                    }
                    return $keyboard;
                })
                ->send();
        } else {
            // ! Sync view_selected_acc_closed_trades() function when updating code here.
            $account = $accounts->first();
            $period = $this->period ?? 12;
            $currency = $account->currency;
            $now = Carbon::now();

            $trades = Trade::where('account_login_id', $account->login_id)
                ->where('close_at', '>=', $now->subHours($period)->toDateTimeString())
                ->closed()
                ->get();

            $this->chat->html(ChatMessageService::recentClosedTrades($trades, $period, $currency))->send();
        }
    }

    public function view_summary()
    {
        // Middlewares
        $this->ensureUserAccountIsExist();
        $this->ensureMTAccountIsExist();
        $this->ensureStorageIsClear(self::STORAGE_DATA_LIST);

        $accounts = $this->chat->user?->mtAccounts;

        if ($accounts->count() > 1) {
            $this->chat->html('Please select the MetaTrader account you want to view:')
                ->keyboard(function (Keyboard $keyboard) use ($accounts) {
                    foreach ($accounts as $account) {
                        $keyboard
                            ->button($account->login_id)
                            ->action('view_selected_acc_summary')
                            ->param('login_id', $account->login_id);
                    }
                    return $keyboard;
                })
                ->send();
        } else {
            // ! Sync view_selected_acc_summary() function when updating code here.
            $account = $accounts->first();
            $period = $this->period ?? 12;
            $now = Carbon::now();
            $currency = $account->currency;

            // Recent Open Trades
            $openTrades = Trade::where('account_login_id', $account->login_id)
                ->where('open_at', '>=', $now->subHours($period)->toDateTimeString())
                ->open()
                ->get();

            // Recent Closed Trades
            $closedTrades = Trade::where('account_login_id', $account->login_id)
                ->where('close_at', '>=', Carbon::now()->subHours($period)->toDateTimeString())
                ->closed()
                ->get();

            $this->chat->html(ChatMessageService::accountDetails($account))->send();
            $this->chat->html(ChatMessageService::recentOpenTrades($openTrades, $period))->send();
            $this->chat->html(ChatMessageService::recentClosedTrades($closedTrades, $period, $currency))->send();
        }
    }

    public function close_all_trades()
    {
        // Middlewares
        $this->ensureUserAccountIsExist();

        $this->queueCommand(__FUNCTION__);
    }

    public function disable_auto_trading()
    {
        // Middlewares
        $this->ensureUserAccountIsExist();

        $this->queueCommand(__FUNCTION__);
    }

    private function queueCommand($command)
    {
        $pendingCommands = $this->chat->pending_commands ?? [];

        if (in_array($command, $pendingCommands)) {
            $this->chat->html("The command '/$command' is already pending processing.")->send();
            return;
        }

        $pendingCommands[] = $command;

        $this->chat->pending_commands = $pendingCommands;
        $this->chat->save();

        $this->chat->html("The command '/$command' has been received and will be processed soon.")->send();
    }

    /* -------------------------------------------------------------------------- */
    /*                                   Actions                                  */
    /* -------------------------------------------------------------------------- */
    public function view_selected_acc_details()
    {
        $loginId = $this->data->get('login_id');
        $account = MTAccount::where('login_id', $loginId)->firstOrFail();
        $this->chat->html(ChatMessageService::accountDetails($account))->send();
    }

    public function view_selected_acc_open_trades()
    {
        $loginId = $this->data->get('login_id');
        $period = $this->period ?? 12;
        $now = Carbon::now();

        $trades = Trade::where('account_login_id', $loginId)
            ->where('open_at', '>=', $now->subHours($period)->toDateTimeString())
            ->open()
            ->get();

        $this->chat->html(ChatMessageService::recentOpenTrades($trades, $period))->send();
    }

    public function view_selected_acc_closed_trades()
    {
        $loginId = $this->data->get('login_id');
        $account = MTAccount::where('login_id', $loginId)->firstOrFail();
        $period = $this->period ?? 12;
        $now = Carbon::now();
        $currency = $account->currency;

        $trades = Trade::where('account_login_id', $loginId)
            ->where('close_at', '>=', $now->subHours($period)->toDateTimeString())
            ->closed()
            ->get();

        $this->chat->html(ChatMessageService::recentClosedTrades($trades, $period, $currency))->send();
    }

    public function view_selected_acc_summary()
    {
        $loginId = $this->data->get('login_id');
        $period = $this->period ?? 12;
        $account = MTAccount::where('login_id', $loginId)->firstOrFail();
        $now = Carbon::now();
        $currency = $account->currency;

        // Recent Open Trades
        $openTrades = Trade::where('account_login_id', $loginId)
            ->where('open_at', '>=', $now->subHours($period)->toDateTimeString())
            ->open()
            ->get();

        // Recent Closed Trades
        $closedTrades = Trade::where('account_login_id', $loginId)
            ->where('close_at', '>=', $now->subHours($period)->toDateTimeString())
            ->closed()
            ->get();

        $this->chat->html(ChatMessageService::accountDetails($account))->send();
        $this->chat->html(ChatMessageService::recentOpenTrades($openTrades, $period))->send();
        $this->chat->html(ChatMessageService::recentClosedTrades($closedTrades, $period, $currency))->send();
    }

    private function handleUserRegistration(int $step, string $text)
    {
        DB::beginTransaction();

        try {
            switch ($step) {
                case 1:
                    $this->chat->storage()->set('registration_name', $text);
                    $this->chat->storage()->set('registration_step', 2);
                    $this->chat->html('Choose a username.')->send();
                    break;
                case 2:
                    $this->chat->storage()->set('registration_username', $text);
                    $this->chat->storage()->set('registration_step', 3);
                    $this->chat->html('Enter your email address.')->send();
                    break;
                case 3:
                    if (!filter_var($text, FILTER_VALIDATE_EMAIL)) {
                        throw new Exception(__('telegram.invalid_email'));
                    }

                    $this->chat->storage()->set('registration_email', $text);
                    $this->chat->storage()->set('registration_step', 4);
                    $this->chat->html('Create a password.')->send();
                    break;
                case 4:
                    $name = $this->chat->storage()->get('registration_name');
                    $username = $this->chat->storage()->get('registration_username');
                    $email = $this->chat->storage()->get('registration_email');
                    $password = $text;

                    $user = $this->userRepository->createUser([
                        'uuid' => (string) Str::uuid(),
                        'name' => $name,
                        'username' => $username,
                        'email' => $email,
                        'password' => Hash::make($password),
                    ]);
                    $user->assignRole('customer');

                    // Update Foreign Key
                    if (empty($this->chat->user)) {
                        $this->chat->user_uuid = $user->uuid;
                        $this->chat->save();
                    }

                    // Send Message
                    $message = ChatMessageService::userRegistrationSuccess($user->uuid);
                    $this->chat->html($message)->send();

                    // Clear Stored Data
                    $this->chat->storage()->forget('registration_step');
                    $this->chat->storage()->forget('registration_name');
                    $this->chat->storage()->forget('registration_username');
                    $this->chat->storage()->forget('registration_email');
                    break;
            }

            DB::commit();
            return;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function handleAccountConnection(string $text)
    {
        $user = User::where('uuid', $text)->first();

        if (empty($user)) {
            throw new Exception(__('telegram.invalid_user_id'));
        }

        $this->chat->user_uuid = $user->uuid;
        $this->chat->save();

        $this->chat->html('Your Telegram account has been successfully linked to your ' . env('APP_NAME', 'platform') .  ' account. Enjoy using our services directly from Telegram!')->send();

        // Clear Stored Data
        $this->chat->storage()->forget('process_acc_connection');
        return;
    }

    /* -------------------------------------------------------------------------- */
    /*                                 Middlewares                                */
    /* -------------------------------------------------------------------------- */
    // ! Temporary solution for middleware implementation.
    // TODO: Refactor it once Laravel Telegraph supports middleware.
    private function ensureUserAccountIsExist()
    {
        if (empty($this->chat->user)) {
            throw new Exception("It seems like you haven't connected to any user account yet. To get started, please connect to a user account using the '/connect' command. If you don't have a user account yet, you can register one through the bot using the '/new_user' command.");
        }

        return true;
    }

    private function ensureMTAccountIsExist()
    {
        if ($this->chat->user?->mtAccounts->isEmpty()) {
            throw new Exception("It seems that we couldn't find your MetaTrader account linked to our system. To ensure connectivity, please ensure your token is stored in the input settings of MT4.");
        }

        return true;
    }

    private function ensureStorageIsClear(array $data)
    {
        // Use this function to manually delete data stored in the storage since Telegraph doesn't support Middleware (Middleware will be released soon).
        foreach ($data as $d) {
            $this->chat->storage()->forget($d);
        }

        return true;
    }

    /* -------------------------------------------------------------------------- */
    /*                            Handle Chat Messages                            */
    /* -------------------------------------------------------------------------- */
    protected function handleChatMessage(Stringable $text): void
    {
        // Handle User Registration
        $registrationStep = $this->chat->storage()->get('registration_step');
        $processAccConnection = $this->chat->storage()->get('process_acc_connection');

        if ($registrationStep) {
            $this->handleUserRegistration($registrationStep, $text);
        } elseif ($processAccConnection) {
            $this->handleAccountConnection($text);
        } else {
            $this->help();
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                           Handle Unknown commands                          */
    /* -------------------------------------------------------------------------- */
    protected function handleUnknownCommand(Stringable $text): void
    {
        if (!self::$handleUnknownCommands) {
            parent::handleUnknownCommand($text);
            return;
        }

        $this->chat->html(ChatMessageService::unknownCommand())->send();
    }

    /* -------------------------------------------------------------------------- */
    /*                               Handle Failures                              */
    /* -------------------------------------------------------------------------- */
    protected function onFailure(Throwable $throwable): void
    {
        if ($throwable instanceof NotFoundHttpException) {
            throw $throwable;
        }

        report($throwable);

        $this->reply($throwable->getMessage());
    }
}
