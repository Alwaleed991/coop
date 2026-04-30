<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Image;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\AIModerator\Facades\OpenAiModerator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Pipelines\Posts\StorePostPayload;
use App\Pipelines\Posts\AttachTags;
use App\Pipelines\Posts\ModerateWithAI;
use App\Pipelines\Posts\SaveImages;
use App\Pipelines\Posts\SavePost;
use App\Pipelines\Posts\ValidatePostInput;
use Illuminate\Support\Facades\Pipeline;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(Post::with(['user', 'tags', 'images'])->latest()->paginate(5)); // PostResource::collection(...) this is to applay the to array logic
        // Multiple items →PostResource::collection($posts) , Single item → new PostResource($post)
    }


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


    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();

        try {

            $payload = new StorePostPayload(
                userId: $request->user()->id,
                title: $request->title,
                body: $request->body,
                images: $request->images,
                imagesPaths: [],
                tags: $request->tags,
                post: null,
            );

            $post = Pipeline::send($payload)  
                ->through([
                    ModerateWithAI::class,
                    SavePost::class,
                    SaveImages::class,
                    AttachTags::class,
                ])
                ->then(fn(StorePostPayload $payload) => $payload->post); // ->then() is basically: "all pipes passed, now what do you want back? i chose $payload->post to store it in the " 

            DB::commit();

            return response()->json([
                'message' => 'Post created successfully',
                'post' => new PostResource($post->load('tags')),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
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
            $input = $request->title . " " . $request->body;

            if (OpenAiModerator::Examine_Text_Content($input)['flagged']) {
                return response()->json([
                    'message' => 'We apologize, but according to our site policies, your post is considered inappropriate.',
                ], 422);
            }
            $post->update([
                'title' => $request->title,
                'body' => $request->body
            ]);

            $tagNames = collect($request->tags)->pluck('name')->toArray();
            $AssociativeArray = [];

            foreach ($tagNames as $tagName) {
                $AssociativeArray[] = ['name' => $tagName];
            }

            Tag::insertOrIgnore($AssociativeArray);

            $tagIds = Tag::whereIn('name', $tagNames)->pluck('id');

            $post->tags()->sync($tagIds); // sync will go to the pvot table and replace the old tags with the new one so its perfect for update



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
        // the delete() set the deleted_at to time stamp
        $post->delete();
        return response()->json([
            'message' => 'Post moved to the trash successfully'
        ], 200);

        // IMPORTANT The row is still there in the DB. But because you added the SoftDeletes trait to the Post model, Laravel automatically adds WHERE deleted_at IS NULL to every query — so the post becomes invisible everywhere in your app.
    }

    public function trashed(Request $request)
    {
        // onlyTrashed() → gets only soft deleted posts (where deleted_at is NOT null)
        return PostResource::collection(Post::onlyTrashed()->where('user_id', $request->user()->id)->with(['user', 'tags', 'images'])->latest('deleted_at')->paginate(5));
    }

    public function restore(Post $post)
    {
        // the restore() set the deleted_at to null
        $post->restore();
        return response()->json([
            'message' => 'Post restored successfully'
        ], 200);
    }

    public function forceDelete(Post $post)
    {
        $paths = [];
        foreach ($post->images as $image) {
            $paths[] = $image->imageUrl;
        }

        Storage::disk('public')->delete($paths);
        $post->forceDelete();

        return response()->json([
            'message' => 'Post permanently deleted successfully'
        ], 200);
    }
}
