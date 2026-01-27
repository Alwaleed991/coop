<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(Post::all()); // PostResource::collection(...) this is to applay the to array logic
                                                      // Multiple items →PostResource::collection($posts) , Single item → new PostResource($post)
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $attributes = $request->validated();
        $userId = $request->user()->id;
        $attributes['user_id'] = $userId;
        $post = Post::create($attributes);

        return response()->json([
            'message' => 'Post created successfully',
            'data' => new PostResource($post),
            ], 201);    
            
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        
        $post->update($request->validated());
        return response()->json([
            'message' => 'Post updated successfully',
            'data' => new PostResource($post),
            ], 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
        'message' => 'Post deleted successfully'
        ], 200); 
    }
}
