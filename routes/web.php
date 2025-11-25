<?php

use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

$backend_controller_path ="App\Http\Controllers\Backend";

Route::get('/', function () {
    return view('welcome');
});


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
});
require __DIR__.'/auth.php';
