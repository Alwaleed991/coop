<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
       $request->validate([
            'keyWord' => ['required', 'string']
        ]);
        $posts = Post::where('title', 'LIKE','%'.$request->keyWord.'%')->get(); // SQL enjection 
        return PostResource::collection($posts);
    }
}
