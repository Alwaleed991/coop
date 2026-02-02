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