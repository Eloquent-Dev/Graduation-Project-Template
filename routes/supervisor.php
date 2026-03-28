<?php

use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\CompletionReportController;

Route::middleware(['auth','role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function(){
    Route::get('job-orders/{jobOrder}/complete',[SupervisorController::class,'createCompletionReport'])
    ->name('completion.create');

    Route::get('/my-reports',[CompletionReportController::class,'index'])
    ->name('reports.index');

    Route::get('/my-reports/{completionReport}',[CompletionReportController::class,'show'])
    ->name('reports.show');


    Route::post('job-orders/{jobOrder}/complete',[SupervisorController::class,'storeCompletionReport'])
    ->name('completion.store');
});
