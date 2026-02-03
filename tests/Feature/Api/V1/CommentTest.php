<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(TestCase::class, RefreshDatabase::class);



it('allows user to lists comments for one post successfully', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    $post = Post::factory()->create([
        'user_id'=>$user->id
    ]);

    $comment = Comment::factory(5)->create([
        'user_id'=> $user->id,
        'post_id'=> $post->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->getJson('/api/v1/posts/'.$post->id.'/comments')
    ->assertStatus(200)
    ->assertJsonCount(5,'data')
    ->assertJsonStructure([
        'data'=> [
            ['id', 'post_id', 'body','user_id']
        ]
    ]);
});

it('does not allows user to lists comments for one post when not authenticated', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id'=>$user->id
    ]);

    Comment::factory(5)->create([
        'user_id'=> $user->id,
        'post_id'=> $post->id
    ]);

    test()->getJson('/api/v1/posts/'.$post->id.'/comments')
    ->assertStatus(401);
});

it('does not allows user to lists comments for post that does not exist', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    $post = Post::factory()->create([
        'user_id'=>$user->id
    ]);

    Comment::factory(5)->create([
        'user_id'=> $user->id,
        'post_id'=> $post->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->getJson('/api/v1/posts/X/comments')
    ->assertStatus(404);
});

it('allows user to store comment successfully', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    $post = Post::factory()->create([
        'user_id'=>$user->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->postJson('/api/v1/posts/'.$post->id.'/comments',[   
        "body"=> "comment body"
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'message',
        'data'=> [
            'id', 'post_id', 'body','user_id'
        ]
    ]);
});


it('does not allows user to store comment when not authenticated', function () {
   $user = User::factory()->create();
   $post = Post::factory()->create([
        'user_id'=>$user->id
    ]);
    test()->postJson('/api/v1/posts/'.$post->id.'/comments',[   
        "body"=> "comment body"
    ])
    ->assertStatus(401);
    
});

it('does not allows user to store comment with empty credentials', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    $post = Post::factory()->create([
        'user_id'=>1
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->postJson('/api/v1/posts/'.$post->id.'/comments',[
        "body" => ""
    ])
    ->assertStatus(422)
    ->assertJsonValidationErrors(['body']);
    
});




it('allows user to update comment that belong to him', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    $post = Post::factory()->create([
        'user_id'=>$user->id
    ]);

    $comment = Comment::factory()->create([
        'user_id'=>$user->id,
        'post_id'=>$post->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->patchJson('/api/v1/comments/'.$comment->id,[  
        "body"=> "New Comment Body"
    ])
    ->assertStatus(200)
    ->assertJsonStructure([
        'message',
        'data'=> [
            'id', 'post_id' , 'body','user_id'
        ]
    ]);
});

it('does not allows user to update comment that does not belong to him', function () {
    $firstUser = User::factory()->create();
    $secondUser = User::factory()->create();
    $token = $firstUser->createToken('auth_token')->plainTextToken;

    $post = Post::factory()->create([
        'user_id'=>$secondUser->id
    ]);

    $comment = Comment::factory()->create([
        'user_id'=>$secondUser->id,
        'post_id'=>$post->id
    ]);


    test()->withHeader('Authorization', 'bearer '.$token)->patchJson('/api/v1/comments/'.$comment->id,[   
        "body"=> "New Comment Body"
    ])
    ->assertStatus(403);
});

it('does not allows user to update comment that does not exist', function () {
    $user = User::factory()->create();
    
    $token = $user->createToken('auth_token')->plainTextToken;

    test()->withHeader('Authorization', 'bearer '.$token)->patchJson('/api/v1/comments/X',[  
        "body"=> "New Comment Body"
    ])
    ->assertStatus(404);
});

it('allows user to distroy comment that belong to him', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    $post = Post::factory()->create([
        'user_id'=>$user->id
    ]);

    $comment = Comment::factory()->create([
        'user_id'=>$user->id,
        'post_id'=>$post->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->deleteJson('/api/v1/comments/'.$comment->id)
    ->assertStatus(200)
    ->assertJsonStructure([
        'message'
    ]);

});

it('does not allows user to delete comment that does not belong to him', function () {
    $firstUser = User::factory()->create();
    $secondUser = User::factory()->create();
    $token = $firstUser->createToken('auth_token')->plainTextToken;

    $post = Post::factory()->create([
        'user_id'=>$secondUser->id
    ]);

    $comment = Comment::factory()->create([
        'user_id'=>$secondUser->id,
        'post_id'=>$post->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->deleteJson('/api/v1/comments/'.$comment->id)
    ->assertStatus(403);
});

it('does not allows user to delete post that does not exist', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    $post = Post::factory()->create([
        'user_id'=>$user->id
    ]);

    $comment = Comment::factory()->create([
        'user_id'=>$user->id,
        'post_id'=>$post->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->deleteJson('/api/v1/comments/X')
    ->assertStatus(404);
});


