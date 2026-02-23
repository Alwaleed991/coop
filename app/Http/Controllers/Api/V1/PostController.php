<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(Post::with(['user', 'tags'])->latest()->paginate(5)); // PostResource::collection(...) this is to applay the to array logic
                                                      // Multiple items →PostResource::collection($posts) , Single item → new PostResource($post)
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $attributes = $request->validated();
        $userId = $request->user()->id;
        
        
        $post = Post::create([
            'user_id' => $userId,
            'title' => $attributes['title'],
            'body' => $attributes['body']
        ]);


        $tags = $attributes['tags'];
        
        foreach($tags as $tag){
            $post->attach_tags_to_post($tag['name']); 
        }

        
        return response()->json([
            'message' => 'Post created successfully',
            'post' => new PostResource($post->load(['user', 'tags'])),
            ], 201);    
            
    }

    public function usersPosts(User $user){
        
        $posts = Post::where('user_id', $user->id)->with(['user', 'tags'])->latest()->paginate(5) ;
        return PostResource::collection($posts);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post->load(['user', 'tags']));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        
        $post->update([
           'title' => $request->validated()['title'],
           'body' => $request->validated()['body']
        ]);

        $names = [];

        foreach($request->tags as $tag){
            $names[] = $tag['name'];
        }

        $post->attach_updated_tags_to_post($names);

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => new PostResource($post->load(['user', 'tags'])),
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
