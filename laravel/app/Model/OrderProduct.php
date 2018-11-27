<?php

namespace App\Model;


/**
 * App\Model\OrderProduct
 *
 * @property int $id
 * @property int $id_order
 * @property int $id_good
 * @property float $price
 * @property int $kol
 * @property float $stoim
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereIdGood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereIdOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereKol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereStoim($value)
 * @mixin \Eloquent
 */
class OrderProduct extends Model
{
    public $table = 'orders_goods';
    public $timestamps = false;

    protected $fillable = [];



}
