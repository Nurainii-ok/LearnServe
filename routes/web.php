<?php

use Illuminate\Support\Facades\Route;

// Halaman Home
Route::get('/', function () {
    return view('home'); // otomatis ke home saat buka website
})->name('home');

// Halaman Auth (Login & Register)
Route::get('/auth', function () {
    return view('auth');
})->name('auth');
