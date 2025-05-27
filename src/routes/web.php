<?php

use App\Livewire\Auth\Login;
use App\Livewire\ProductList;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/produtos', function () {
//     return view('products');
// });

Route::get('/produtos', ProductList::class)->name('products');

Route::get('/login', Login::class)->name('login');
Route::get('/logout', function () {
    return redirect()->route('login');
})->name('logout');