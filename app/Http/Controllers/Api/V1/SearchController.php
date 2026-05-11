<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Elastic\Elasticsearch\ClientBuilder;
use App\Services\ES\Facades\EsFacade;



class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        try {
            $request->validate([
                'keyWord' => ['required', 'string']
            ]);

           
            $result = EsFacade::search($request->keyWord);

            $hits = $result->asArray()['hits']['hits'];

            $ids = collect($hits)->pluck('_id')->toArray();

            $posts = Post::whereIn('id', $ids)->get();

            return PostResource::collection($posts);
        } catch (\Exception $e) {
            Log::info('this is the message========>>>>>>>'. $e->getMessage());
        }
    }
}
