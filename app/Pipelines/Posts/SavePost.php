<?php

namespace App\Pipelines\Posts;


use Closure;
use App\Models\Post;

class SavePost
{

    public function __construct() {}

    public function handle(mixed $payload, Closure $next)
    {

        $post = Post::create([
            'user_id' => $payload->userId,
            'title' => $payload->title,
            'body' => $payload->body
        ]);

        $payload->post = $post;

        return $next($payload);
    }
}
