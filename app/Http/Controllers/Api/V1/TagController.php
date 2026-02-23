<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class TagController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Tag::all(['id','name']),
        ], 200);
    }

    public function filter(Request $request){
        $request->validate([
            "selectedTags" => ["required", "array"]
        ]);


        $filteredPosts = collect();
        foreach($request->selectedTags as $selectedTag){
            $tag = Tag::where("id",$selectedTag["id"])->first();
            $filteredPosts = $filteredPosts->merge($tag->posts->load("tags"));
        }
        $filteredPosts = $filteredPosts->unique('id'); // this for removing dublication 
        return PostResource::collection($filteredPosts); // this is Regular Collection the load is not working here
    }
}



// 🎯 load() works on:

// ✅ 1. Single Eloquent Model
// $post = Post::find(1);  // Single Post model

// $post->load('tags');  // ✅ Works! Loads tags for this post
// $post->load('user');  // ✅ Works! Loads user
// $post->load(['tags', 'user', 'comments']);  // ✅ Load multiple

// ✅ 2. Eloquent Collection
// $posts = Post::all();  // Eloquent Collection

// $posts->load('tags');  // ✅ Works! Loads tags for ALL posts
// $posts->load(['tags', 'user']);  // ✅ Load multiple

// ✅ 3. Relationship (returns Eloquent Collection)
// $user = User::find(1);

// $user->posts->load('tags');  // ✅ Works!



// ❌ load() does NOT work on:
// Regular Collection (from collect())
// php$collection = collect([Post1, Post2, Post3]);

// $collection->load('tags');  // ❌ ERROR!
// // Type: Illuminate\Support\Collection (no load method!)