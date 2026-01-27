<?php

use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function(){
    Route::get('/posts',[PostController::class, 'index']);
    Route::post('/posts',[PostController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/posts/{post}',[PostController::class, 'show']);
    Route::patch('/posts/{post}',[PostController::class, 'update']);
    Route::delete('/posts/{post}',[PostController::class, 'destroy']);
    // Route::get('/posts/{post}/comments',[PostController::class, 'postComments'] );
    Route::post('/comments',[CommentController::class, 'store']);
    Route::patch('/comments/{comment}',[CommentController::class, 'update']);
    Route::delete('/comments/{comment}',[CommentController::class, 'destroy']);
});



// if the req pass middleware('auth:sanctum') then the user will be add to the req and you can access it by $request->user()->id;
// GET    /api/v1/tasks
// POST   /api/v1/tasks
// GET    /api/v1/tasks/{task}
// PUT    /api/v1/tasks/{task}
// DELETE /api/v1/tasks/{task}
