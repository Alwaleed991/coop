<?php

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(TestCase::class, RefreshDatabase::class);

it('allows user to list all post successfully', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    Post::factory(3)->create([
        'user_id'=>$user->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->getJson('/api/v1/posts')
    ->assertOk()
    ->assertJsonCount(3,'data')
    ->assertJsonStructure([
        'data'=> [
            ['id', 'title', 'body','user_id']
        ]
    ]);
});


it('does not allow user to list posts when not authenticated', function () {
    $user = User::factory()->create();

    Post::factory(3)->create([
        'user_id'=>$user->id
    ]);

    test()->getJson('/api/v1/posts')
    ->assertStatus(401);
});

it('allows user to store post successfully', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;


    test()->withHeader('Authorization', 'bearer '.$token)->postJson('/api/v1/posts',[
        "title"=>"post title",   
        "body"=> "post body"
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'message',
        'data'=> [
            'id', 'title', 'body','user_id'
        ]
    ]);
});


it('does not allows user to store post when not authenticated', function () {
   
    test()->postJson('/api/v1/posts',[
        "title"=>"post title",   
        "body"=> "post body"
    ])
    ->assertStatus(401);
    
});

it('does not allows user to store post with empty credentials', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;


    test()->withHeader('Authorization', 'bearer '.$token)->postJson('/api/v1/posts',[
        "title"=>"",   
        "body"=> ""
    ])
    ->assertStatus(422)
     ->assertJsonValidationErrors(['title','body']);
    
});

it('allows user to show single post', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    $posts = Post::factory(3)->create([
        'user_id'=>$user->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->getJson('/api/v1/posts/'.$posts[1]->id)
    ->assertStatus(200)
    ->assertJsonStructure([
        'data'=> [
            'id', 'title', 'body','user_id'
        ]
    ]);
    
});

it('does not allows user to show single post when not authenticated', function () {
    $user = User::factory()->create();

    $posts = Post::factory(3)->create([
        'user_id'=>$user->id
    ]);

    test()->getJson('/api/v1/posts/'.$posts[1]->id)
    ->assertStatus(401);
    
});

it('does not allows user to show single post that does not exist', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    $posts = Post::factory(3)->create([
        'user_id'=>$user->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->getJson('/api/v1/posts/X')
    ->assertStatus(404);
});

it('allows user to update post that belong to him', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    $posts = Post::factory(3)->create([
        'user_id'=>$user->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->patchJson('/api/v1/posts/'.$posts[1]->id,[
        "title"=>"how to get job in USA",   
        "body"=> "etc..."
    ])
    ->assertStatus(200)
    ->assertJsonStructure([
        'message',
        'data'=> [
            'id', 'title', 'body','user_id'
        ]
    ]);
});

it('does not allows user to update post that does not belong to him', function () {
    $firstUser = User::factory()->create();
    $secondUser = User::factory()->create();
    $token = $firstUser->createToken('auth_token')->plainTextToken;

    $posts = Post::factory(3)->create([
        'user_id'=>$secondUser->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->patchJson('/api/v1/posts/'.$posts[1]->id,[
        "title"=>"how to get job in USA",   
        "body"=> "etc..."
    ])
    ->assertStatus(403);
});

it('does not allows user to update post that does not exist', function () {
    $user = User::factory()->create();
    
    $token = $user->createToken('auth_token')->plainTextToken;

    test()->withHeader('Authorization', 'bearer '.$token)->patchJson('/api/v1/posts/X',[
        "title"=>"how to get job in USA",   
        "body"=> "etc..."
    ])
    ->assertStatus(404);
});

it('allows user to distroy post that belong to him', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    $posts = Post::factory(3)->create([
        'user_id'=>$user->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->deleteJson('/api/v1/posts/'.$posts[1]->id)
    ->assertStatus(200)
    ->assertJsonStructure([
        'message'
    ]);

});

it('does not allows user to delete post that does not belong to him', function () {
    $firstUser = User::factory()->create();
    $secondUser = User::factory()->create();
    $token = $firstUser->createToken('auth_token')->plainTextToken;

    $posts = Post::factory(3)->create([
        'user_id'=>$secondUser->id
    ]);

    test()->withHeader('Authorization', 'bearer '.$token)->deleteJson('/api/v1/posts/'.$posts[1]->id)
    ->assertStatus(403);
});

it('does not allows user to delete post that does not exist', function () {
    $user = User::factory()->create();
    
    $token = $user->createToken('auth_token')->plainTextToken;

    test()->withHeader('Authorization', 'bearer '.$token)->deleteJson('/api/v1/posts/X')
    ->assertStatus(404);
});