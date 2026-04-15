<?php

namespace App\Services\AIModerator\Repositories;

use OpenAI\Laravel\Facades\OpenAI;
use App\Services\AIModerator\Exceptions\ModeratorException;

class OpenAiModeratorRepository implements OpenAiModeratorInterface
{
    private String $model;

    public function __construct()
    {
        $this->model = 'omni-moderation-latest';
    }

    public function Examine_Text_Content(String $input)
    {

        try {
            $response = OpenAI::moderations()->create([
                'model' => $this->model,
                'input' => $input
            ]);

            return $response->results[0]->flagged;
        } catch (\Exception $e) {
            throw new ModeratorException('Moderation service unavailable');
        }
    }
}
