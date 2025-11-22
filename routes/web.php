<?php

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
    });
    
require __DIR__.'/auth.php';
