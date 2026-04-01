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
use Illuminate\Support\Facades\DB;

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
    // public function store(StorePostRequest $request)
    // {

    //     DB::beginTransaction(); // Start tracking changes, but DON'T save them yet! From this point, all database changes are TEMPORARY They're in memory, not in the actual database , think of it like (git all)

    //     try {
    //         $attributes = $request->validated();
    //         $userId = $request->user()->id;


    //         $post = Post::create([
    //             'user_id' => $userId,
    //             'title' => $attributes['title'],
    //             'body' => $attributes['body']
    //         ]);

    //         $tags = [];

    //         foreach ($request->validated()['tags'] as $tag) { // there is still N+1 problome but we improve it by 40% by extracting the attach out side the loop and we make the logic in one place so there is no attach_tags_to_post($tag['name']) any more 

    //             $tag = Tag::firstOrCreate([
    //                 'name' => $tag['name']
    //             ]);
    //             $tags[] = $tag['id'];
    //             // $post->attach_tags_to_post($tag['name']);
    //         }

    //         $post->tags()->attach($tags); // note the attach can recive an array


    //         DB::commit(); // Everything worked! Save all changes permanently! in the DB

    //         return response()->json([
    //             'message' => 'Post created successfully',
    //             'post' => new PostResource($post->load(['user', 'tags'])),
    //         ], 201);
    //     } catch (\Exception $e) {
    //         DB::rollBack(); // Something failed! Undo EVERYTHING! and go back on how the database where it was 
    //         return response()->json([
    //             'message' => 'faild to create your post please try again later',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function usersPosts(User $user)
    {

        $posts = Post::where('user_id', $user->id)->with(['user', 'tags'])->latest()->paginate(5);
        return PostResource::collection($posts);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post->load(['user', 'tags']));
    }



    // public function store(StorePostRequest $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $post = Post::create([
    //             'user_id' => $request->user()->id,
    //             'title' => $request->title,
    //             'body' => $request->body,
    //         ]);


    //         // Get all tag names
    //         $tagNames = collect($request->tags)->pluck('name')->toArray(); // now here collect($request->tags) this will create collection of assositive array and we will pluck the name so it will create an collection of strings becouse name is string and then we will preform toArray() to return normal array 
    //         // Find existing tags (ONE query)
    //         $existingTags = Tag::whereIn('name', $tagNames)->get(); // where() -> SELECT * FROM tags WHERE name = 'Laravel' AND whereIn() -> SELECT * FROM tags WHERE name IN ('Laravel', 'PHP', 'Vue') and note the $existingTags will be a collection becuse we get them from the Tag::class
    //         $existingTagNames = $existingTags->pluck('name')->toArray();

    //         // Find new tag names
    //         $newTagNames = array_diff($tagNames, $existingTagNames); //array_diff() finds items in the FIRST array that are NOT in the SECOND array!

    //         // Create new tags
    //         $newTags = collect();
    //         foreach ($newTagNames as $tagName) {  // if the $newTagNames was empty this for loop will mot run
    //             $tag = Tag::create(['name' => $tagName]);
    //             $newTags->push($tag); // the push here is the way to append to collection 
    //         }

    //         // Combine and attach
    //         $allTags = $existingTags->merge($newTags);
    //         $post->tags()->attach($allTags->pluck('id'));


    //         DB::commit();

    //         return response()->json([
    //             'message' => 'Post created successfully',
    //             'post' => new PostResource($post->load('tags')),
    //         ], 201);
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return response()->json([
    //             'message' => 'Failed to create your post. Please try again later.',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }



    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();

        try {

            $path = $request->imageUrl->store('postsImages', 'public'); // this the path will be postsImages/randomBylaravel.png

            $post = Post::create([
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'body' => $request->body,
                'imageUrl' => $path
            ]);

            $tagNames = collect($request->tags)->pluck('name')->toArray();

            Tag::insertOrIgnore(
                collect($tagNames)->map(fn($name) => ['name' => $name])->toArray()
            );

            $tagIds = Tag::whereIn('name', $tagNames)->pluck('id');

            $post->tags()->attach($tagIds);

            DB::commit();

            return response()->json([
                'message' => 'Post created successfully',
                'post' => new PostResource($post->load('tags')),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create your post. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {

        DB::beginTransaction();
        try {
            $post->update([
                'title' => $request->validated()['title'],
                'body' => $request->validated()['body']
            ]);

            $tagNames = collect($request->tags)->pluck('name')->toArray();
            $existingTags = Tag::whereIn('name', $tagNames)->get();
            $existingTagNames = $existingTags->pluck('name')->toArray();

            $newTagNames = array_diff($tagNames, $existingTagNames);
            $newTags = collect();
            foreach ($newTagNames as $tagName) {
                $tag = Tag::create(['name' => $tagName]);
                $newTags->push($tag);
            }

            $allTags = $newTags->merge($existingTags);

            $post->tags()->sync($allTags); // sync will go to the pvot table and replace the old tags with the new one so its perfect for update


            DB::commit();
            return response()->json([
                'message' => 'Post updated successfully',
                'post' => new PostResource($post->load(['user', 'tags'])),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'faild to update your post please try again later',
                'error' => $e->getMessage(),
            ], 500);
        }
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
