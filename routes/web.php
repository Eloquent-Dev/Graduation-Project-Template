<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Middleware\RequiredCompleteProfile;

require __DIR__.'/auth.php';
require __DIR__.'/guest.php';
require __DIR__.'/dispatcher.php';
require __DIR__.'/worker.php';
require __DIR__.'/supervisor.php';
require __DIR__.'/admin.php';
require __DIR__.'/categories.php';


Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/complaints/create',[ComplaintController::class,'create'])
->middleware(RequiredCompleteProfile::class)
->name('complaints.create');

Route::post('/complaints',[ComplaintController::class, 'store'])
->middleware(RequiredCompleteProfile::class)
->name('complaints.store');
