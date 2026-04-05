<?php

use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\JobTitleApprovalController;

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){

    Route::get('/reviews',[ReviewController::class,'index'])->name('reviews.index');
    Route::get('/reviews/{jobOrder}',[ReviewController::class,'show'])->name('reviews.show');
    Route::patch('/reviews/{jobOrder}/process',[ReviewController::class,'process'])->name('reviews.process');

    //User Management Routes
    Route::get('/users',[UsersController::class,'index'])->name('users.index');
    Route::patch('/users/{user}/role',[UsersController::class,'updateRole'])->name('users.update_role');
    Route::delete('/users/{user}',[UsersController::class,'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/division',[UsersController::class,'updateDivision'])->name('users.update_division');
    Route::get('/users/{user}/complaints',[UsersController::class,'complaints'])->name('users.complaints.index');
    Route::patch('/complaints/{complaint}/update',[UsersController::class,'updateDetails'])->name('users.complaints.update');
    Route::get('/users/complaints/{complaint}',[UsersController::class,'showComplaint'])->name('users.complaints.show');
    Route::get('/users/{user}/profile',[UsersController::class,'showProfile'])->name('users.showProfile');

    //Report Generation Routes
    Route::get('/reports',[ReportController::class,'index'])->name('reports.index');
    Route::post('/reports/generate',[ReportController::class,'generate'])->name('reports.generate');
    Route::get('/reports/{report}',[ReportController::class,'show'])->name('reports.show');

    //Category Management Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');


    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/job-title-pending',[JobTitleApprovalController::class,'index'])->name('job-title.index');
    Route::post('/job-title/{employee}/approve',[JobTitleApprovalController::class,'approve'])->name('job-title.approve');
    Route::post('/job-title/{employee}/reject',[JobTitleApprovalController::class,'reject'])->name('job-title.reject');
});
