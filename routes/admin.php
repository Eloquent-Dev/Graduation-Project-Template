<?php

use App\Http\Controllers\Admin\ReviewController;

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){

    Route::get('/reviews',[ReviewController::class,'index'])->name('reviews.index');
    Route::get('/reviews/{jobOrder}',[ReviewController::class,'show'])->name('reviews.show');
    Route::patch('/reviews/{jobOrder}/process',[ReviewController::class,'process'])->name('reviews.process');
});
