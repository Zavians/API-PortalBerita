<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\postController;
use App\Http\Controllers\commentController;
use App\Http\Controllers\AuthenticationController;

// Rute Nama Tabel - > Nama Controller - > Nama Fungsi -> Middleware (Jika Ada)

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/infoUserLogin', [AuthenticationController::class, 'userInfo']);

    Route::post('/posts', [postController::class, 'store']);
    Route::patch('/posts/{id}', [postController::class, 'update'])->middleware('post_owner');
    Route::delete('/posts/{id}', [postController::class, 'destroy'])->middleware('post_owner');

    Route::post('/comment', [commentController::class, 'store']);
    Route::patch('/comment/{id}', [CommentController::class, 'update'])->middleware('comment_owner');
    Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->middleware('comment_owner');
});


Route::get('/posts', [postController::class, 'Index']);
Route::get('/posts/{id}', [postController::class, 'showPost']);


Route::post('/login', [AuthenticationController::class, 'login']);
