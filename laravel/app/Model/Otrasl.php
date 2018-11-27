<?php

namespace App\Model;


/**
 * App\Model\Otrasl
 *
 * @property int $id
 * @property int $id_gr
 * @property string $name
 * @property string $text
 * @property int $sort
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property int $status
 * @property int|null $clickCount
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereClickCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereIdGr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereTitle($value)
 * @mixin \Eloquent
 * @property-read mixed $url
 */
class Otrasl extends Model
{
    protected $table = 'otr';


    public function getUrlAttribute()
    {
        return '/otrasl/'.$this->slug.'/';
    }

}
