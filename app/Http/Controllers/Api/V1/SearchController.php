<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Elastic\Elasticsearch\ClientBuilder;


class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
                    Log::info('we are in baby');

        try {
            $request->validate([
                'keyWord' => ['required', 'string']
            ]);

            $client = ClientBuilder::create()
                ->setHosts([env('ELASTICSEARCH_HOST') . ':' . env('ELASTICSEARCH_PORT')])
                ->build();

            $result = $client->search([
                'index' => 'posts',
                'body'  => [
                    'query' => [
                        'multi_match' => [
                            'query'  => $request->keyWord,
                            'fields' => ['title', 'body']
                        ]
                    ]
                ]
            ]);

            $hits = $result->asArray()['hits']['hits'];

            $ids = collect($hits)->pluck('_id')->toArray();

            $posts = Post::whereIn('id', $ids)->get();

            return PostResource::collection($posts);
        } catch (\Exception $e) {
            Log::info('this is the message========>>>>>>>'. $e->getMessage());
        }
    }
}
