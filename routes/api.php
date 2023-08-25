<?php

use App\Http\Controllers\API\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TelegramUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/list', [UserController::class, 'list'])->name('list');
    Route::get('/details/{id}', [UserController::class, 'details'])->name('details');
});

Route::prefix('telegram-users')->name('telegramUsers.')->group(function () {
    Route::get('/list', [TelegramUserController::class, 'list'])->name('list');
});

Route::prefix('members')->name('members.')->group(function () {
    Route::get('/list', [MemberController::class, 'list'])->name('list');
});