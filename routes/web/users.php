<?php

use App\Http\Controllers\Users\PermissionController;
use App\Http\Controllers\Users\RoleController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('users', UserController::class)
        ->names('users');
    Route::resource('roles', RoleController::class)
        ->names('roles');
    Route::resource('permissions', PermissionController::class)
        ->names('permissions');
});
