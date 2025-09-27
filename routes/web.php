<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FE\CommentController;
use App\Http\Controllers\FE\HomeController;
use App\Http\Controllers\FE\PostController;
use App\Http\Controllers\FE\ContactController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\FE\CategoryController;

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

Route::get('/posts/{slug}', [PostController::class, 'showNews'])->name('posts.show');
Route::get('/search', [PostController::class, 'search'])->name('search');
Route::get('/search-page', [PostController::class, 'searchPage'])->name('search.page');
Route::get('/search-pages', [PostController::class, 'loadSearch'])->name('search.page.load');


Route::middleware('guest')->group(function () {
    Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google.login');
    Route::get('auth/google/callback', [GoogleController::class, 'callback']);
});

Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/comments', 
    [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{comment}/toggle-like', 
    [CommentController::class, 'toggleLike'])->name('comments.toggle-like');
    Route::delete('/comments/{id}', 
    [CommentController::class, 'destroy'])->name('comments.destroy');
    
    
    Route::post('/logout', [GoogleController::class, 'logout'])
    ->name('logout');
});

