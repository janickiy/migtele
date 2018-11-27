<?php

namespace App\Model;


/**
 * App\Model\ExchangeRate
 *
 * @property int $id
 * @property string $date
 * @property float $usd
 * @property float $eur
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ExchangeRate whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ExchangeRate whereEur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ExchangeRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ExchangeRate whereUsd($value)
 * @mixin \Eloquent
 */
class ExchangeRate extends Model
{
    protected $table = 'valuta';

    public $timestamps = false;

    protected $guarded = [];


    /**
     * static helpers
     */

    /**
     * @param $currency
     * @return int
     */
    public static function getRate($currency){

        $rate = self::orderBy('date', 'desc')->remember(5)->first()->toArray();

        return isset($rate[$currency]) ? self::getWithMarkup($rate[$currency], $currency) : 0;

    }

    /**
     * @param $value
     * @param $currency
     * @return mixed
     */
    public static function getWithMarkup($value, $currency) {

        $markup = 0;

        switch ($currency){

            case 'eur':
                $markup = _setting("eur_up");
                break;

            case 'usd':
                $markup = _setting("usd_up");
                break;

        }

        $markup = is_numeric($markup) ? $markup : 0;

        return $value + ($markup * $value / 100);

    }

}
