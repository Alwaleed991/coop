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
