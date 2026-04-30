<?php

namespace App\Pipelines\Posts;

use Closure;
use App\Models\Image;



class SaveImages
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

        $records = [];

        foreach ($payload->imagesPaths as $path) {
            $records[] = [
                'imageUrl' => $path,
                'post_id' => $payload->post->id
            ];
        }




        Image::insert($records);


        return $next($payload);
    }
}
