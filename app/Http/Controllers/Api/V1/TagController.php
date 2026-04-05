<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\Post;

class TagController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Tag::all(['id', 'name']),
        ], 200);
    }

    public function filter(Request $request)
    {
        $request->validate([
            "selectedTags" => ["required", "array"]
        ]);

        $tagIds = collect($request->selectedTags)->pluck('id');

        $posts = Post::whereHas('tags', function ($query) use ($tagIds) {
            $query->whereIn('tags.id', $tagIds);
        })
            ->with(['user', 'tags'])
            ->latest()
            ->get();

        // this for removing dublication, unique('id') is a Collection method only.
        return PostResource::collection($posts); // this is Regular Collection the load is not working here
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
