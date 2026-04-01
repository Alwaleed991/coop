<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'body'       => $this->body,
            'imageUrl'   => $this->imageUrl,
            'user_id'    => $this->user_id,
            'author'     => $this->user->name,
            'created_at' => $this->created_at->toDateTimeString(),
            'tags'       => $this->tags->map(function($tag){  // here the map return a collection
                    return [
                        'id' => $tag->id,
                        'name' => $tag->name
                    ];
            })
        ];
    }
}
