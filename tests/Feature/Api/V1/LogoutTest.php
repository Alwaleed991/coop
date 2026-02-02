<?php

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(TestCase::class, RefreshDatabase::class);



it('allows user to logout successfully', function () {
    $user = User::factory()->create();

    $token = $user->createToken('auth_token')->plainTextToken;

    test()->withHeader('Authorization', 'bearer '.$token)->postJson('/api/v1/logout')
    ->assertOk()
    ->assertJsonStructure([
        'message'
    ]);
});


it('does not allow user to logout without authentication', function () {
    test()->postJson('/api/v1/logout')->assertStatus(401);
});

it('does not allow user to logout with fake token', function () {
    test()->withHeader('Authorization', 'bearer FAKE_TOKEN')->postJson('/api/v1/logout')
    ->assertStatus(401);
});

