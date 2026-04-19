<?php

namespace App\Services\AIModerator\Repositories;

use OpenAI\Laravel\Facades\OpenAI;
use App\Services\AIModerator\Exceptions\ModeratorException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;



class OpenAiModeratorRepository implements OpenAiModeratorInterface
{
    private String $model;

    public function __construct()
    {
        $this->model = 'omni-moderation-latest';
    }

    public function Examine_Text_Content(string $text, array $images = [])
    {
        try {
            $paths = [];
            $i = 0;

            $responses = Http::pool(function ($pool) use ($text, $images, &$paths, $i) {
                $pools = [];
                // Text request
                $pools[] = $pool->as('text')
                    ->withToken(config('openai.api_key'))
                    ->post('https://api.openai.com/v1/moderations', [
                        'model' => $this->model,
                        'input' => [['type' => 'text', 'text' => $text]],
                    ]);

                // Image requests
                foreach ($images as $image) {
                    $path = $image->store('postsImages', 'public');
                    $paths[] = $path;
                    $content = file_get_contents(storage_path('app/public/' . $path));
                    $mimeType = mime_content_type(storage_path('app/public/' . $path));

                    $pools[] = $pool->as("image_{$i}")
                        ->withToken(config('openai.api_key'))
                        ->post('https://api.openai.com/v1/moderations', [
                            'model' => $this->model,
                            'input' => [[
                                'type' => 'image_url',
                                'image_url' => [
                                    'url' => 'data:' . $mimeType . ';base64,' . Str::toBase64($content)
                                ]
                            ]],
                        ]);
                        $i++;
                }
                return $pools;
            });

            // Check if anything is flagged
            foreach ($responses as $response) {
                if ($response->json('results.0.flagged')) { // the response will be json not SDK response so $response->results[0]->flagged will not work 
                    // Delete saved images if flagged
                    foreach ($paths as $path) {
                        Storage::disk('public')->delete($path);
                    }
                    return ['flagged' => true];
                }
            }

            return [
                'flagged' => false,
                'paths' => $paths
            ];
        } catch (\Exception $e) {
            throw new ModeratorException('Moderation service unavailable');
        }
    }
}
