<?php
Route::get('/categories', [\App\http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [\App\http\Controllers\Admin\CategoryController::class, 'show'])->name('categories.show');
