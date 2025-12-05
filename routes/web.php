<?php

use App\Http\Controllers\Backend\AttendanceController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

$backend_controller_path ="App\Http\Controllers\Backend";

Route::get('/', function () {
    return view('welcome');
});
Route::get('/cal', function () {
    return view('frontend.lone-calculator');
});
Route::get('/ui1', function () {
    return view('frontend.ui1');
});
Route::get('/calculator', function () {
    // return view('frontend.calculator');
    return view('frontend.lone-calculator');
})->middleware(['auth'])->name('calculator');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')
    ->namespace($backend_controller_path)
    ->group(function () {
        Route::post('/contact/submit', 'ContactController@submit')
            ->name('admin.contact.submit');
        Route::post('/contact/index', 'ContactController@submit')
            ->name('admin.contact.index');
    });
    Route::prefix('admin')->group(function () {
    Route::get('/contact-submissions', [ContactController::class, 'index'])->name('contact.submissions.index');
    Route::get('/contact-submissions/{contactSubmission}', [ContactController::class, 'show'])->name('contact.submissions.show');
    Route::put('/contact-submissions/{contactSubmission}/status', [ContactController::class, 'updateStatus'])->name('contact.submissions.update-status');
})->middleware(['auth']);
Route::middleware(['auth'])->group(function () {
    Route::resource('employees', EmployeeController::class);
})->name('employees');
Route::get('/profile/view/{uid}', [EmployeeController::class, 'showPublicProfile'])->name('profile.public');
Route::middleware(['auth'])->group(function () {
    // Daily Attendance Entry
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    
    // Employee Report
    Route::get('/attendance/report/{user_id}', [AttendanceController::class, 'report'])->name('attendance.report');
});
require __DIR__.'/auth.php';
