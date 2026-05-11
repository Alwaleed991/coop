<?php

namespace App\Services\ES\Repositories;

use App\Services\ES\Client\EsClient;
use Illuminate\Support\Facades\Log;
use Elastic\Elasticsearch\Client;


class EsRepository
{

public Client $client;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->client = app(EsClient::class)->client;
    }

    public function search($query)
    {

                Log::info('the seaeching is starting');


        $result = $this->client->search([
                'index' => 'posts',
                'body'  => [
                    'query' => [
                        'multi_match' => [
                            'query'  => $query,
                            'fields' => ['title', 'body']
                        ]
                    ]
                ]
            ]);

            Log::info('the seaeching is done and the result is ' . json_encode($result->asArray()));


            return $result;
    }

    public function index($id, $body, $title)
    {       
        
    
    Log::info('we are in baby the repo');

        $this->client->index([
            'index' => 'posts',
            'id'    => $id,
            'body'  => [
                'title' => $title,
                'body'  => $body,
            ]
        ]);
    }





}
