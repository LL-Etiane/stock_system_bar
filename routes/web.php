<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Pages\Home::class)
    ->name('home');

Route::get('products', App\Livewire\Pages\Products\Index::class)
    ->name('products.index');
Route::get('products/create', App\Livewire\Pages\Products\Add::class)
    ->name('products.add');
Route::get('stock', App\Livewire\Pages\StockManagement::class)->name('stock.index');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
