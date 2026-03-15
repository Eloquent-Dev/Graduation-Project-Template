<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\oAuth\GoogleController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\NotificationController;


Route::middleware('auth')->group(function(){
    Route::post('/logout',[AuthController::class,'logout'])
    ->name('logout');

    Route::post('/oauth/finish', [GoogleController::class,'finishRegistration'])
    ->name('oauth.finish');

    Route::get('/my-complaints',[ComplaintController::class,'index'])
    ->name('complaints.index');

    Route::get('/my-complaints/{complaint}',[ComplaintController::class,'show'])
    ->name('complaints.show');

    Route::get('/notifications/{id}/read', [NotificationController::class,'markAsRead'])
    ->name('notifications.read');

    Route::get('/notifications/mark-all-read',[NotificationController::class,'markAllRead'])
    ->name('notifications.markAllRead');

});
