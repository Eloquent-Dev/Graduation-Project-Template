<?php

use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\UsersController;

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){

    Route::get('/reviews',[ReviewController::class,'index'])->name('reviews.index');
    Route::get('/reviews/{jobOrder}',[ReviewController::class,'show'])->name('reviews.show');
    Route::patch('/reviews/{jobOrder}/process',[ReviewController::class,'process'])->name('reviews.process');

    //User Management Routes
    Route::get('/users',[UsersController::class,'index'])->name('users.index');
    Route::patch('/users/{user}/role',[UsersController::class,'updateRole'])->name('users.update_role');
    Route::delete('/users/{user}',[UsersController::class,'destroy'])->name('users.destroy');
});
