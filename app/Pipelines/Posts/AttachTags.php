<?php

namespace App\Pipelines\Posts;

use Closure;
use App\Models\Tag;





class AttachTags
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function handle(mixed $payload, Closure $next)
    {


        $tagNames = collect($payload->tags)->pluck('name')->toArray(); // [veu, node, laravel]

        $AssociativeArray = [];
        foreach ($tagNames as $tagName) {
            $AssociativeArray[] = ['name' => $tagName];
        }

        Tag::insertOrIgnore($AssociativeArray);

        $tagIds = Tag::whereIn('name', $tagNames)->pluck('id');

        $payload->post->tags()->attach($tagIds);

        return $next($payload);
    }
}
