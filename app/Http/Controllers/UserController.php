<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\TelegraphBot;
use Illuminate\Http\Request;
use App\Enums\UserStatusesEnum;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        return Inertia::render('Profile/Show');
    }

    public function editPassword(Request $request)
    {
        return Inertia::render('Profile/ChangePassword');
    }

    public function settings()
    {
        $bot = TelegraphBot::active()->first();

        return Inertia::render('Profile/Settings', [
            'bot' => $bot
        ]);
    }

    public function toggleStatus(Request $request, User $user)
    {
        $message = $user->status === UserStatusesEnum::ACTIVE->value ?
            'Account had deactivated' :
            'Account had activated';

        $user->update([
            'status' => $user->status === UserStatusesEnum::ACTIVE->value ?
                UserStatusesEnum::INACTIVE->value :
                UserStatusesEnum::ACTIVE->value
        ]);

        return redirect()->back()->with('success', $message);
    }
}
