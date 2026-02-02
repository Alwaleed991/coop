<?php

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(TestCase::class, RefreshDatabase::class);



it('allows user to register and receive token', function () {

    test()->postJson('/api/v1/register', [
        'name' => 'Alwaleed',
        'email' => fake()->unique()->safeEmail(), // why the email should not be hard coded ???
        'password' => 'sdlFlkn@1',
        'password_confirmation' => 'sdlFlkn@1'
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'message',
        'token',
        'user',
    ]);
});

it('does not allows user to register with duplicate email', function () {

    $user = User::factory()->create();

    test()->postJson('/api/v1/register', [
        'name' => 'Alwaleed',
        'email' => $user->email,
        'password' => 'sdlFlkn@1',
        'password_confirmation' => 'sdlFlkn@1'
    ])
    ->assertStatus(422)
    ->assertJsonValidationErrors(['email']);
});

it('does not allow user to register when password confirmation does not match', function () {

    test()->postJson('/api/v1/register', [
        'name' => 'Alwaleed',
        'email' => fake()->unique()->safeEmail(),
        'password' => 'sdlFlkn@1',
        'password_confirmation' => 'alsfnlaS@8'
    ])
    ->assertStatus(422)
    ->assertJsonValidationErrors(['password']);
});


it('does not allow user to register when weak password is uesd', function () {

    test()->postJson('/api/v1/register', [
        'name' => 'Alwaleed',
        'email' => fake()->unique()->safeEmail(),
        'password' => 'password',
        'password_confirmation' => 'password'
    ])
    ->assertStatus(422)
    ->assertJsonValidationErrors(['password']);
});