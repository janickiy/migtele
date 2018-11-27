<?php

namespace App\Helpers;

abstract class HelperProducts{

    public static function all()
    {
        return [];
    }


    public static function count()
    {
        return count(static::all());
    }

}