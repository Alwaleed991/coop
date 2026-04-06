<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Post;
use App\Notifications\NewCommentNotification;

class CommentController extends Controller
{
   

    public function postComments(Post $post){
        $comments = $post->comments()->latest()->get();

        return response()->json([
            'data' => CommentResource::collection($comments->load('user')),
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $attributes = $request->validated();
        $userId = $request->user()->id;
        $attributes['user_id'] = $userId;
        $attributes['post_id'] = $post->id;

        $comment = Comment::create($attributes);

        $post->user->notify(new NewCommentNotification($comment));



         return response()->json([
            'message' => 'comment created successfully',
            'data' => new CommentResource($comment->load('user')),
            ], 201);

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());
        return response()->json([
            'message' => 'comment updated successfully',
            'data' => new CommentResource($comment->load('user')),
            ], 200); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            'message' => 'comment deleted successfully',
            ], 200); 
    }
}
