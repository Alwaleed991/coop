<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class PlatformStatsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
         return response()->json([
                'postCount' => Post::count(),
                'commentCount' => Comment::count(),
                'userCount' => User::count(),
            ], 201);
    }
}
