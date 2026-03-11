<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;

require __DIR__.'/auth.php';
require __DIR__.'/guest.php';

Route::get('/', function () {
    return view('landing');
})->name('home');

    Route::get('/complaints/create',[ComplaintController::class,'create'])
    ->name('complaints.create');

    Route::post('/complaints',[ComplaintController::class, 'store'])
    ->name('complaints.store');