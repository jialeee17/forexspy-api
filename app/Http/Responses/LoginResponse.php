<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        // https://talltips.novate.co.uk/laravel/laravel-8-conditional-login-redirects
        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->intended(auth()->user()->hasRole(['customer']) ? route('dashboard') : route('admin.dashboard'));
    }
}
