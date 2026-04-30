<?php

namespace App\Pipelines\Posts;

use App\Services\AIModerator\Facades\OpenAiModerator;
use Closure;

use Illuminate\Support\Facades\Log;



class ModerateWithAI
{


    public function __construct()
    {
        //
    }

    public function handle(mixed $payload, Closure $next)
    {

        $textInput = $payload->title . " " . $payload->body;
        $imageInput = $payload->images ?? [];

        $result = OpenAiModerator::Examine_Text_Content($textInput, $imageInput);

        if ($result['flagged']) {

         throw new \Exception('We apologize, but according to our site policies, your post is considered inappropriate.');
            return response()->json([
                'message' => 'We apologize, but according to our site policies, your post is considered inappropriate.',
            ], 422);
        }

        $payload->imagesPaths = $result['paths'];

        return $next($payload);
    }
}
