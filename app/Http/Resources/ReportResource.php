<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => $this->category,
            'reason' => $this->reason,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),

            'reporter' => [
                'id' => $this->user_id,
                'name' => $this->user->name,
            ],

            'reportable' => [
                'type' => class_basename($this->reportable_type),  
                'id' => $this->reportable_id,
                'author' => [
                    'id' => $this->reportable->user_id, // VERY IMPORTAT NOTE WHEN EVER YOU TYPE reportable ITS THE POST OR COMMENT MODEL SO IN THE POST MODEL THERE IS FUNCTION NAMED user
                    'name' => $this->reportable->user->name,
                ],
            ],
        ];
    }
}
