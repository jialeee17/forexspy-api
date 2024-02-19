<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Enums\UserStatusesEnum;

class UserController extends Controller
{
    public function editPassword(Request $request)
    {
        return Inertia::render('User/Users/Profiles/ChangePassword');
    }

    public function settings()
    {
        return Inertia::render('Settings/Index');
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
