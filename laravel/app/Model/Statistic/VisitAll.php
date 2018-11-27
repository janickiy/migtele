<?php

namespace App\Model\Statistic;


use App\Model\Model;

/**
 * App\Model\Statistic\VisitAll
 *
 * @property string $date
 * @property int $unic
 * @property int $whole
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Statistic\VisitAll whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Statistic\VisitAll whereUnic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Statistic\VisitAll whereWhole($value)
 * @mixin \Eloquent
 */
class VisitAll extends Model
{
    protected $primaryKey = 'date';

    protected $table = 'visit_all';
    public $timestamps = false;

    protected $dates = ['date'];

    protected $fillable = [
        'date',
        'unic',
        'whole'
    ];

}
