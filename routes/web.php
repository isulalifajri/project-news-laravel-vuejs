<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FE\HomeController;
use App\Http\Controllers\FE\CategoryController;
use App\Http\Controllers\FE\PostController;

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
