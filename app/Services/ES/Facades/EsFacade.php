<?php

namespace App\Services\ES\Facades;

use App\Services\ES\Repositories\EsInterface;
use Illuminate\Support\Facades\Facade;

class EsFacade extends Facade
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
        return EsInterface::class;
    }



    //note: this EsFacade::index() internally becomes something like: app(EsInterface::class)->index()



}
