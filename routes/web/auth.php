<?php

use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::group(['prefix' => 'auth'], function () {
    Route::get('/google/login', function () {
        return Socialite::driver('google')->redirect();
    })->name('google.login');

    Route::get('/google/callback', [UserController::class, 'googleSignInCallback'])
        ->name('google.callback');
});
