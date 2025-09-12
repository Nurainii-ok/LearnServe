<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;

// Halaman Auth (Login & Register dalam 1 file)
Route::get('/auth', function () {
    return view('auth');
})->name('auth');

// Login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Register
Route::post('/register',[AuthController::class, 'register'])->name('register.post');

// Logout
// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Halaman Umum
Route::prefix('/')->middleware(['prevent-back'])->group(function () {
    Route::get('/', [PagesController::class, 'home'])->name('home');
    Route::get('/learning', [PagesController::class, 'learning'])->name('learning');
    Route::get('/bootcamp', [PagesController::class, 'bootcamp'])->name('bootcamp');
    Route::get('/webinar', [PagesController::class, 'webinar'])->name('webinar');
    Route::get('/deskripsi_kelas', [PagesController::class, 'deskripsiKelas'])->name('deskripsi_kelas');
    Route::get('/detail_kursus', [PagesController::class, 'detailKursus'])->name('detail_kursus');
    Route::get('/form_payments', [PagesController::class, 'formPayments'])->name('form_payments');
    Route::get('/beli_sekarang', [PagesController::class, 'beliSekarang'])->name('beli_sekarang');
    Route::get('/form_pendaftaran', [PagesController::class, 'formPendaftaran'])->name('form_pendaftaran');
    Route::get('/kelas', [PagesController::class, 'kelas'])->name('kelas');
});



// Member
Route::middleware(['role:member','prevent-back'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin
Route::prefix('admin')->middleware(['role:admin','prevent-back'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

// Tutor
Route::prefix('tutor')->middleware(['role:tutor','prevent-back'])->name('tutor.')->group(function () {
    Route::get('/dashboard', [TutorController::class, 'dashboard'])->name('dashboard');
    Route::get('/classes', [TutorController::class, 'classes'])->name('classes');
    Route::get('/tasks', [TutorController::class, 'tasks'])->name('tasks');
    Route::get('/account', [TutorController::class, 'account'])->name('account');
});
