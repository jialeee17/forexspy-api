<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::webhooks('webhooks/trade-history-received');
Route::webhooks('webhooks/new-trade-received');

Route::middleware(['guest'])->get('admin/login', [AuthController::class, 'login'])->name('admin.login');

Route::middleware(['auth', 'verified', config('jetstream.auth_session')])->group(function () {
    // * Admin Routes
    Route::middleware(['role:super-admin|admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', function () {
                return Inertia::render('Admin/Dashboard/Index');
            })->name('dashboard');

            Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');
            Route::get('/edit-password', [UserController::class, 'editPassword'])->name('password.edit');
            Route::get('/settings', [UserController::class, 'settings'])->name('setting.show');
        });

    // * Customer Routes
    Route::middleware(['role:customer'])
        ->group(function () {
            Route::get('/', function (Request $request) {
                return Inertia::render('User/Dashboard/Index');
            })->name('dashboard');

            Route::prefix('users')
                ->name('user.')
                ->group(function () {
                    Route::get('/edit-password', [UserController::class, 'editPassword'])->name('password.edit');
                    Route::put('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->withoutMiddleware(['role:customer'])->name('toggleStatus');
                    Route::get('/settings', [UserController::class, 'settings'])->name('setting.show');
                });
        });
});
