<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\oAuth\GoogleController;

Route::middleware('auth')->group(function(){
    Route::post('logout',[AuthController::class,'logout'])->name('logout');
    Route::post('/oauth/finish', [GoogleController::class,'finishRegistration'])->name('oauth.finish');
});
