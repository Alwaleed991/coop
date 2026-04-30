<?php

namespace App\Pipelines\Posts;

use App\Models\Post;

class StorePostPayload
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $userId,
        public string $title,
        public string $body,
        public array $images,
        public array $imagesPaths,
        public array $tags,
        public ?Post $post = null,
    ) {}
}
