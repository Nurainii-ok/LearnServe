<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Halaman Member
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/learning', function () {
    return view('learning');
})->name('learning');

Route::get('/bootcamp', function () {
    return view('bootcamp');
})->name('bootcamp');

Route::get('/webinar', function () {
    return view('webinar');
})->name('webinar');

Route::get('/deskripsi_kelas', function () {
    return view('deskripsi_kelas');
})->name('deskripsi_kelas');

Route::get('/form_payments', function () {
    return view('form_payments');
})->name('form_payments');

Route::get('/form_pendaftaran', function () {
    return view('form_pendaftaran');
})->name('form_pendaftaran');

Route::get('/kelas', function () {
    return view('kelas');
})->name('kelas');

// Halaman Auth (Login & Register)
Route::get('/auth', function () {
    return view('auth');
})->name('auth');

// Login
Route::get('/login', function () {
    return view('auth'); // bisa arahkan ke view 'auth'
})->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('login.post');

// Register
Route::get('/register', [AuthController::class, 'formregister'])->name('register');
Route::post('/register',[AuthController::class, 'prosesRegister'])->name('register.post');

Route::get('/profile', function () {
    $member = \App\Models\Member::find(1); // ambil member ID 1
    return view('profile', compact('member'));
})->name('profile');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('auth')->with('success', 'Berhasil logout.');
})->name('logout');




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
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
});

// Halaman Tutor
Route::prefix('tutor')->name('tutor.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/members', [AdminController::class, 'members'])->name('members');
    Route::get('/members/create', [AdminController::class, 'createMember'])->name('members.create');
    Route::get('/tutors', [AdminController::class, 'tutors'])->name('tutors');
    Route::get('/classes', [AdminController::class, 'classes'])->name('classes');
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
    Route::get('/tasks', [AdminController::class, 'tasks'])->name('tasks');
    Route::get('/account', [AdminController::class, 'account'])->name('account');
});
