<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('login', function() {
    return view('livewire.pages.auth.login');
});


Route::get('kategori', function() {
    return view('kategori');
})->name('kategori');

Route::get('brand', function() {
    return view('brand');
})->name('brand');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

require __DIR__.'/auth.php';
