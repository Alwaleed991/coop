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


        //Exactly right! notify() fills all the columns actually, not just data. Let's see what each one gets filled:
        // Column            Filled with  
        // id                Auto generated UUID
        // type              App\Notifications\NewCommentNotification
        // notifiable_type   App\Models\User
        // notifiable_id     the post owner's id
        // data              the array from toDatabase() as JSON
        // read_at           null (unread by default)
        // created_at        current timestamp
        // updated_at        current timestamp

        // You are calling notify() on the User model instance ->user->. So Laravel looks at that user object and automatically knows:
        // notifiable_type → the class of the object = App\Models\User
        // notifiable_id → the id of that object = $post->user->id

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
