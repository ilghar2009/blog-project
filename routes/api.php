<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Session\Middleware\AuthenticateSession;

// dashboard
    Route::middleware(['Auth'])->group(function(){

        Route::middleware(['Admin'])->group(function(){
            Route::apiResource('/category', CategoryController::class);
            Route::apiResource('/blog', BlogController::class);
            Route::apiResource('/user', UserController::class);
            Route::apiResource('/comment', CommentController::class);
        });

        Route::apiResource('/favorite', FavoriteController::class);
        Route::get('/reply', [ReplyController::class, 'reply']);
    });


//login and sign
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'sign'])->name('register');

// index
    Route::get('/', [ShowController::class, 'index'])->name('index');
    Route::get('/show/{id}', [ShowController::class, 'show'])->name('show');
