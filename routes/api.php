<?php

use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\LogoutController;
use App\Http\Controllers\Api\V1\PlatformStatsController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\RegisterController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\SearchController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Report;
use OpenAI\Laravel\Facades\OpenAI;










Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// All routes inside:routes/api.php automatically get this prefix: /api
Route::prefix('v1')->group(function () {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::get('/test-ai', function () {
        $response = OpenAI::moderations()->create([
            'model' => 'omni-moderation-latest',
            'input' => 'hello world',
        ]);

        dd($response->results[0]);
    });
    // ENHANCE: use api resources
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', LogoutController::class);
        Route::get('/posts', [PostController::class, 'index']);

        Route::get('/users/{user}/posts', [PostController::class, 'usersPosts']);

        Route::post('/posts', [PostController::class, 'store']);
        Route::post('/posts/{post}/images', [PostController::class, 'storeImages']);
        Route::get('posts/trashed', [PostController::class, 'trashed']);
        Route::get('/posts/{post}', [PostController::class, 'show']);
        Route::patch('/posts/{post}', [PostController::class, 'update'])->can('update', 'post'); // the policy will be exicuted after the middleware('auth:sanctum')
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->can('delete', 'post');
        Route::patch('posts/{post}/restore', [PostController::class, 'restore'])->withTrashed()->can('forceDelete', 'post'); // withTrashed() It's telling Laravel's route model binding to include soft deleted records when looking up a post by ID.
        Route::delete('posts/{post}/force-delete', [PostController::class, 'forceDelete'])->withTrashed()->can('restore', 'post');
        Route::get('/posts/{post}/comments', [CommentController::class, 'postComments']);
        Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
        Route::patch('/comments/{comment}', [CommentController::class, 'update'])->can('update', 'comment');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->can('delete', 'comment');
        Route::get('/reports', [ReportController::class, 'index'])->can('view', Report::class);
        Route::post('/reports', [ReportController::class, 'store']);
        Route::post('/search', SearchController::class);
        Route::get('/tags', [TagController::class, 'index']);
        Route::post('/filter', [TagController::class, 'filter']);
        Route::get('/status', PlatformStatsController::class);
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::get('/notifications/count', [NotificationController::class, 'notificationsCount']);
        Route::get('/notifications/mark/read', [NotificationController::class, 'markAllAsRead']);
    });
});



// if the req pass middleware('auth:sanctum') then the user will be add to the req and you can access it by $request->user()->id;
// GET    /api/v1/tasks
// POST   /api/v1/tasks
// GET    /api/v1/tasks/{task}
// PUT    /api/v1/tasks/{task}
// DELETE /api/v1/tasks/{task}



// So without withTrashed():
// PATCH /posts/5/restore  →  Laravel looks for post 5
//                         →  post 5 is soft deleted
//                         →  Laravel returns 404 ❌
// With withTrashed():
// PATCH /posts/5/restore  →  Laravel looks for post 5
//                         →  post 5 is soft deleted but included
//                         →  Laravel finds it and restores it ✅