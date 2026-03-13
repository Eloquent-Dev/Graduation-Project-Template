<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DispatcherController;

Route::middleware(['auth','role:dispatcher'])->prefix('dispatcher')->name('dispatcher.')->group(function(){

    Route::get('/job-orders',[DispatcherController::class,'index'])
    ->name('job_orders.index');

    Route::get('/job-orders/{jobOrder}',[DispatcherController::class,'show'])
    ->name('job_orders.show');

    Route::patch('/job-orders/{jobOrder}',[DispatcherController::class,'update'])
    ->name('job_orders.update');
});

