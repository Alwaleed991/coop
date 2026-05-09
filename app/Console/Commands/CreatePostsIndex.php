<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Elastic\Elasticsearch\ClientBuilder;

class CreatePostsIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-posts-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $client = ClientBuilder::create()
            ->setHosts([env('ELASTICSEARCH_HOST') . ':' . env('ELASTICSEARCH_PORT')])
            ->build();

        $client->indices()->create([
            'index' => 'posts',
            'body'  => [
                'mappings' => [ // mappings defines the fields types for this index, telling ES how to treat each field when storing and searching. 'title' and 'body' are defined as 'text' so ES can perform full-text search on them.
                    'properties' => [
                        'title' => ['type' => 'text'],
                        'body'  => ['type' => 'text'],
                    ]
                ]
            ]
        ]);

        $this->info('Posts index created!');
    }
}
