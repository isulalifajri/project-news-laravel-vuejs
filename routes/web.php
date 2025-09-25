<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FE\HomeController;
use App\Http\Controllers\FE\CategoryController;

// Route::get('/', function () {
//     return Inertia::render('Home');
// })->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/category/{slug}', [CategoryController::class, 'show'])
    ->name('category.show');

Route::get('/show', function () {
    return Inertia::render('Posts/show', [
        'errors' => (object)[], // kasih props kosong biar inertia gak error
    ]);
})->name('show');
