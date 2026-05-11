<?php

namespace App\Services\ES\Providers;

use App\Services\ES\Client\EsClient;
use App\Services\ES\Repositories\EsInterface;
use App\Services\ES\Repositories\EsRepository;
use Illuminate\Support\ServiceProvider;

class EsProvider extends ServiceProvider
{
    /**
     * Create a new class instance.
     */
    

    public function register()
    {
        app()->singleton(EsClient::class, function () {
            return new EsClient();
        });

        match ($this->app->environment()){
            'local' => $this->app->bind(EsInterface::class, EsRepository::class),
            // 'production' => $this->app->bind(EsInterface::class, EsRepository::class)  you can set the production case here!!!
        };
    }
}
