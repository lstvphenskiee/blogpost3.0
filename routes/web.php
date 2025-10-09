<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthOr404;
use App\Http\Middleware\PreventBack;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;

Route::middleware('guest')
    ->controller(AuthController::class)->group(function () {
        Route::get('/', 'loginForm')->name('login-module');
        Route::post('/login', 'login')->name('login-form');
        Route::get('/registers', 'registerForm')->name('register-module');
        Route::post('/register', 'register')->name('register-form');
    });

Route::post('/logout', [AuthController::class, 'logout'])->name('logout-module');

Route::middleware([AuthOr404::class, PreventBack::class])->group(function() {
    Route::controller(PostController::class)->group(function() {
        Route::get('/dashboard', 'index')->name('blog.index');
        Route::get('/create-post', 'create')->name('blog.create');
        Route::get('/posts/{post}/comments', 'fetchComments')->name('blog.fetchComments');
        Route::post('/posts/{post}/comment', 'addComment')->name('blog.comment');
        Route::post('/posts', 'store')->name('blog.store');
        Route::put('/posts/{post}', 'update')->name('blog.update');
        Route::delete('/posts/{post}', 'destroy')->name('blog.destroy');
    });

    Route::controller(CommentController::class)->group(function() {
        Route::put('/comments/{comment}', 'update')->name('comment.update');
        Route::delete('/comments/{comment}', 'destroy')->name('comment.destroy');
    });
});
