<?php

namespace App\Services\AIModerator\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AIModerator\Repositories\OpenAiModeratorInterface;
use App\Services\AIModerator\Repositories\OpenAiModeratorRepository;

class ModeratorProvider extends ServiceProvider
{
    public function register()
    {
        match ($this->app->environment()){
            'local' => $this->app->bind(OpenAiModeratorInterface::class,OpenAiModeratorRepository::class),
            // 'production' => $this->app->bind(OpenAiModeratorInterface::class,OpenAiModeratorRepository::class)  you can set the production case here!!!
        };
    }
}
