<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class PromocodesFacade extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'promocodes';
    }

}