<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class LogoutResponse implements LogoutResponseContract
{

    public function toResponse($request)
    {
        // https://stackoverflow.com/questions/65822861/laravel-fortify-logout-redirect
        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : redirect()->intended($request->is_admin ? route('admin.login') : route('login'));
    }
}
