<?php

namespace App\Model;


/**
 * App\Model\Slider
 *
 * @property int $id
 * @property string $name
 * @property string|null $url
 * @property int|null $sort
 * @property int|null $in_homepage
 * @property int|null $hide
 * @property-read mixed $img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider homepage()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider whereInHomepage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider whereUrl($value)
 * @mixin \Eloquent
 */
class Slider extends Model
{

    public function getImgAttribute()
    {
        $file_path =  '/img/sliders/'.$this->id.'.jpg';


        return @file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_path) ? $file_path : '';
    }

    /**
     * Scopes
     */

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHomepage($query)
    {
        return $query->where('in_homepage', 1);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('hide', 0);
    }


    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort($query)
    {
        return $query->orderBy('sort');
    }

}
