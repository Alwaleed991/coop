<?php

namespace App\Pipelines\Posts;

use Closure;
use App\Models\Tag;
use Elastic\Elasticsearch\ClientBuilder;





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

        $client = ClientBuilder::create()
            ->setHosts([env('ELASTICSEARCH_HOST') . ':' . env('ELASTICSEARCH_PORT')])
            ->build();

        $client->index([
            'index' => 'posts',
            'id'    => $payload->post->id,
            'body'  => [
                'title' => $payload->post->title,
                'body'  => $payload->post->body,
            ]
        ]);

        return $next($payload);
    }
}