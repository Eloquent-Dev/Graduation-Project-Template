<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\oAuth\GoogleController;
use App\Http\Controllers\ComplaintController;


Route::middleware('auth')->group(function(){
    Route::post('/logout',[AuthController::class,'logout'])
    ->name('logout');

    Route::post('/oauth/finish', [GoogleController::class,'finishRegistration'])
    ->name('oauth.finish');

    Route::get('/my-complaints',[ComplaintController::class,'index'])
    ->name('complaints.index');

    Route::get('/my-complaints/{complaint}',[ComplaintController::class,'show'])
    ->name('complaints.show');

});
