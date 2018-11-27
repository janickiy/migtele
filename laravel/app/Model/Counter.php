<?php

namespace App\Model;


/**
 * App\Model\Counter
 *
 * @property int $id
 * @property string $html
 * @property string $note
 * @property int $sort
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Counter whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Counter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Counter whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Counter whereSort($value)
 * @mixin \Eloquent
 * @property string|null $position
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Counter wherePosition($value)
 */
class Counter extends Model
{


    public static function getBottom(){

        return self::orderBy('sort', 'desc')->where('position', 'bottom')->get();

    }

    public static function getTop(){

        return self::orderBy('sort', 'desc')->where('position', 'top')->get();

    }

}
