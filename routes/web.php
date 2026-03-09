<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
require __DIR__.'/guest.php';

Route::get('/', function () {
    return view('landing');
})->name('home');

