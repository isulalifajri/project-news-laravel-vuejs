<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FE\HomeController;
use App\Http\Controllers\FE\PostController;
use App\Http\Controllers\FE\ContactController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\FE\CategoryController;

// Route::get('/', function () {
//     return Inertia::render('Home');
// })->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/category/{slug}', [CategoryController::class, 'show'])
    ->name('category.show');

Route::get('/category/{slug}/posts', [CategoryController::class, 'posts'])
    ->name('category.posts');

Route::get('/news', [PostController::class, 'index'])
    ->name('posts');
Route::get('/news/posts', [PostController::class, 'posts'])
    ->name('posts.news');

Route::get('/show/{slug}', [PostController::class, 'showNews'])->name('show.news');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::middleware('guest')->group(function () {
    Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google.login');
    Route::get('auth/google/callback', [GoogleController::class, 'callback']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [GoogleController::class, 'logout'])
        ->name('logout');
});

