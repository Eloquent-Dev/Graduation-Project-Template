<?php
Route::get('/categories', [\App\http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');

