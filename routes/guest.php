<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\oAuth\GoogleController;
use App\Http\Controllers\oAuth\MicrosoftController;

Route::middleware('guest')->group(function(){
    Route::post('login',[AuthController::class,'login'])->name('login');
    Route::post('register',[AuthController::class,'register'])->name('register');

    Route::get('auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

    Route::get('auth/microsoft/redirect', [MicrosoftController::class, 'redirectToMicrosoft'])->name('microsoft.redirect');
    Route::get('auth/microsoft/callback', [MicrosoftController::class, 'handleMicrosoftCallback'])->name('microsoft.callback');
});
