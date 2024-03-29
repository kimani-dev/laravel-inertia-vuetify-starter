<?php

use App\Http\Controllers\AccessLogsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // users
    Route::resource('users', UserController::class)
        ->names('users');
    //user notifications - mark as read
    Route::put('/users/{user}/notifications', [UserController::class, 'MarkNotificationsAsRead'])
        ->name('users.notifications.mark-as-read');
    //roles and permissions
    Route::resource('roles', RoleController::class);
    //logs
    Route::get('/logs', [AccessLogsController::class, 'index'])
        ->name('logs.index');
});
