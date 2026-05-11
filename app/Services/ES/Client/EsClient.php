<?php

namespace App\Services\ES\Client;


use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class EsClient
{
    /**
     * Create a new class instance.
     */

    public Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([env('ELASTICSEARCH_HOST') . ':' . env('ELASTICSEARCH_PORT')])
            ->build();
    }
}
