<?php

namespace Tests\Feature\Api\V1;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_get_list_of_posts(){
        //Arrange: create tow posts
        $user = User::factory()->create();
        $posts = Post::factory(2)->create([
            'user_id' => $user->id,
        ]);
        

        //Act: make Get req to the index end-point
        $res = $this->getJson('/api/v1/posts');
        
        //Assert
        $res->assertOk();
        $res->assertJsonCount(2,'data');
        $res->assertJsonStructure([
            'data'=>[
                ['id' ,'user_id' ,'title', 'body']
            ]
        ]);
    }

    public function test_user_can_get_single_post(){
        //Arrange: create tow posts
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);

        //Act: make Get req to the index end-point
        $res = $this->getJson('/api/v1/posts/'.$post->id);
        
        //Assert
        $res->assertOk();
        $res->assertJsonStructure([
            'data'=>[
                'id' ,'user_id', 'title', 'body' 
            ]
        ]);

        $res->assertJson([
            'data'=>[
                'id' => $post->id,
                'user_id' => $user->id,
                'title'=> $post->title,
                'body'=>$post->body
            ]
        ]);
    }



}
