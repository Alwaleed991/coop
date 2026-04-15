<?php

namespace App\Services\AIModerator\Facades;

use App\Services\AIModerator\Repositories\OpenAiModeratorInterface;
use Illuminate\Support\Facades\Facade;

class OpenAiModerator extends Facade
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    protected static function getFacadeAccessor(): string
    {
        return OpenAiModeratorInterface::class;
    }
}
