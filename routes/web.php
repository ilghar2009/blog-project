<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard/category', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/dashboard/blog',[BlogController::class,'index'])->name('blogs.index');
Route::get('/dashboard/comment',[CommentController::class,'index'])->name('comments.index');
