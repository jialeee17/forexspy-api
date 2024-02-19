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

Route::webhooks('webhooks');

Route::middleware(['guest'])->get('admin/login', [AuthController::class, 'login'])->name('admin.login');

Route::middleware(['auth', 'verified', config('jetstream.auth_session')])->group(function () {
    // * Shared Routes
    Route::prefix('users')
        ->name('user.')
        ->group(function () {
            // Route::prefix('profiles')
            //     ->name('profile.')->group(function () {
            //         Route::get('/', function () {
            //             return Inertia::render('User/Users/Profiles/UserProfile');
            //         })->name('index');

            //         Route::get('/edit', function () {
            //             return Inertia::render('User/Users/Profiles/EditProfile');
            //         })->name('edit');
            //     });

            Route::get('/edit-password', [UserController::class, 'editPassword'])->name('password.edit');
            Route::put('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggleStatus');
            Route::get('/settings', [UserController::class, 'settings'])->name('setting.index');
        });

    // * Admin Routes
    Route::middleware(['role:super-admin|admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', function () {
                return Inertia::render('Admin/Dashboard/Index');
            })->name('dashboard');

            // Settings
            Route::prefix('settings')->name('setting.')->group(function () {
                Route::get('/', [SettingController::class, 'edit'])->name('edit');
                Route::put('/', [SettingController::class, 'update'])->name('update');
            });
        });

    // * Customer Routes
    Route::middleware(['role:customer'])
        ->group(function () {
            Route::get('/', function (Request $request) {
                return Inertia::render('User/Dashboard/Index');
            })->name('dashboard');
        });
});
