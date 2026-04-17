<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\oAuth\GoogleController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CitizenProfileController;
use App\Http\Controllers\FeedbackController;


Route::middleware('auth')->group(function(){
    Route::post('/logout',[AuthController::class,'logout'])
    ->name('logout');

    Route::post('/oauth/finish', [GoogleController::class,'finishRegistration'])
    ->name('oauth.finish')->middleware('throttle:oauth');

    Route::get('/my-complaints',[ComplaintController::class,'index'])
    ->name('complaints.index');

    Route::get('/my-complaints/{complaint}',[ComplaintController::class,'show'])
    ->name('complaints.show');

    Route::get('/notifications/{id}/read', [NotificationController::class,'markAsRead'])
    ->name('notifications.read');

    Route::get('/notifications/mark-all-read',[NotificationController::class,'markAllRead'])
    ->name('notifications.markAllRead');

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    Route::get('/citizen/profile',[CitizenProfileController::class,'show'])->name('citizen.profile.show');

    Route::get('/citizen/profile/edit',[CitizenProfileController::class,'edit'])->name('citizen.profile.edit');
    Route::patch('/citizen/profile/update',[CitizenProfileController::class,'update'])->name('citizen.profile.update');

    Route::patch('/citizen/profile/password/update',[CitizenProfileController::class,'updatePassword'])->name('citizen.profile.password.update')->middleware('throttle:password');

    Route::post('/complaints/{complaint}/feedback',[FeedbackController::class,'store'])
    ->name('feedback.store')
    ->middleware('throttle:feedback');

    Route::get('/my-history',[LogController::class,'index'])->name('complaints.log');
});
