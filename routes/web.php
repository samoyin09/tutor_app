<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect('tutor/dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Tutor routes
Route::middleware(['auth', 'role:tutor'])->group(function () {
    Route::get('/tutor/dashboard', [TutorController::class, 'dashboard'])->name('tutor.dashboard');
    Route::get('/tutor/select-student', [TutorController::class, 'selectStudent'])->name('tutor.selectStudent');
    Route::match(['get', 'post'], '/tutor/store-scores', [TutorController::class, 'storeScores'])->name('tutor.storeScores');
   
    
});

// Student routes
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
});
