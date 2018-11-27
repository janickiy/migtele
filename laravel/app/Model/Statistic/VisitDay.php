<?php

namespace App\Model\Statistic;


use App\Model\Model;
use Carbon\Carbon;

/**
 * App\Model\Statistic\VisitDay
 *
 * @property string $ip
 * @property string $date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Statistic\VisitDay whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Statistic\VisitDay whereIp($value)
 * @mixin \Eloquent
 */
class VisitDay extends Model
{
    protected $table = 'visit_day';
    public $timestamps = false;

    protected $dates = ['date'];

    protected $fillable = [
        'ip',
        'date'
    ];




    public static function setVisit()
    {


        if(!VisitDay::where('date', date("Y-m-d"))->count()){

            if ($day = VisitDay::first()){

                $visitors = VisitDay::count();
                $uniques = VisitDay::distinct()->count();

                $visit_all = VisitAll::where('date', $day->date)->first();


                if($visit_all) {
                    $visit_all->whole += $visitors;
                    $visit_all->unic += $uniques;

                    $visit_all->save();
                }

                else{
                    VisitAll::create([
                        'date' => $day->date,
                        'whole' => $visitors,
                        'unic' => $uniques
                    ]);
                }



                VisitDay::truncate();

            }

        }


        if(isset($_SERVER['REMOTE_ADDR']))
            self::create([
                'ip' => $_SERVER['REMOTE_ADDR'],
                'date' => Carbon::now()
            ]);

    }

}
