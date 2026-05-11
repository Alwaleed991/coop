<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\ES\Client\EsClient;

class IndexPostJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $id, public $title, public $body )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(EsClient $client): void
    {
        $client->client->index([
            'index' => 'posts',
            'id'    => $this->id,
            'body'  => [
                'title' => $this->title,
                'body'  => $this->body,
            ]
        ]);
    }
}

// chatbot