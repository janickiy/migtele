<?php

namespace App\Model;


/**
 * App\Model\Setting
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string $value
 * @property int $sort
 * @property int $hide
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereValue($value)
 */
class Setting extends Model
{
    public $timestamps = false;
    protected $table = 'settings';

    protected $fillable = [
        'id',
        'type',
        'name',
        'value',
        'sort',
        'hide'
    ];

    
}
