<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Halaman Home
Route::get('/', function () {
    return view('home'); // otomatis ke home saat buka website
})->name('home');

// Halaman Auth (Login & Register)
Route::get('/auth', function () {
    return view('auth');
})->name('auth');

// Halaman Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/members', [AdminController::class, 'members'])->name('members');
    Route::get('/members/create', [AdminController::class, 'createMember'])->name('members.create');
    Route::get('/tutors', [AdminController::class, 'tutors'])->name('tutors');
    Route::get('/classes', [AdminController::class, 'classes'])->name('classes');
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
    Route::get('/tasks', [AdminController::class, 'tasks'])->name('tasks');
    Route::get('/account', [AdminController::class, 'account'])->name('account');
});