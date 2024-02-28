<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TelegraphController;

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

Route::prefix('telegraph-chats')->name('telegraphChat.')->group(function () {
    Route::get('/{user_uuid}/pending-commands', [TelegraphController::class, 'getPendingCommands'])->name('pendingCommand.index');
    Route::post('/{user_uuid}/remove-pending-commands', [TelegraphController::class, 'removePendingCommand'])->name('pendingCommand.remove');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});