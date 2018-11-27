<?php
namespace App\Helpers\LaravelMeta\Tags;

class MetaName extends TagAbstract
{
    public static function tagDefault($key, $value)
    {
        return '<meta name="'.$key.'" content="'.$value.'" />';
    }
}
