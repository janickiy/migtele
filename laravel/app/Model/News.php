<?php

namespace App\Model;


/**
 * App\Model\News
 *
 * @property int $id
 * @property string $date
 * @property string $name
 * @property string $text1
 * @property string $text2
 * @property-read mixed $description
 * @property-read mixed $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\News whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\News whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\News whereText1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\News whereText2($value)
 * @mixin \Eloquent
 */
class News extends Model
{

    public function getUrlAttribute()
    {
        return '/news/'.$this->id.'.htm';
    }

    public function getDescriptionAttribute()
    {
        return strip_tags($this->text1);
    }


}
