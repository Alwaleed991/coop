<?php

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(TestCase::class, RefreshDatabase::class);



it('allows user to login and receive token', function () {
    $user = User::factory()->create();

    // ENHANCE: you can use postJson method without test()
    test()->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
    ->assertOk()
    ->assertJsonStructure([
        'message',
        'token',
        'user',
    ]);
});


it('not allows user to login with invalid credentials', function(){
    $user = User::factory()->create();

    test()->postJson('/api/v1/login', [
        'email' => 'wrongEmail@gmail.com',
        'password' => 'password',
    ])
    ->assertStatus(422)
    ->assertJsonValidationErrors(['password']);

});

it('not allows user to login with empty credentials', function(){
    $user = User::factory()->create();

    test()->postJson('/api/v1/login', [
        'email' => '',
        'password' => '',
    ])
    ->assertStatus(422)
    ->assertJsonValidationErrors(['email','password']);

});


