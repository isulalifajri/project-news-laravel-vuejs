<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/category', function () {
    return Inertia::render('Categories/index');
})->name('category');

Route::get('/show', function () {
    return Inertia::render('Posts/show', [
        'errors' => (object)[], // kasih props kosong biar inertia gak error
    ]);
})->name('show');

