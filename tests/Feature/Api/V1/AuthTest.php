<?php

namespace Tests\Feature\Api\V1;
use App\Models\User;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
   use RefreshDatabase;
   public function test_user_can_login_and_receive_token(){
        $user = User::factory()->create();

        $res = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $res->assertOk();
        $res->assertJsonStructure([
                'message' ,'token' ,'user'
        ]);
   }

   public function test_user_can_not_login_with_invalid_credentials(){
        $user = User::factory()->create();

        $res = $this->postJson('/api/v1/login', [
            'email' => 'example@gmail.com',
            'password' => 'wrong-password'
        ]);

        $res->assertStatus(422);
        $res->assertJsonValidationErrors(['password']);

   }
}
