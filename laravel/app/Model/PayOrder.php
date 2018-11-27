<?php

namespace App\Model;


/**
 * App\Model\PayOrder
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $number
 * @property float $amount
 * @property string|null $comment
 * @property int $is_pay
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayOrder whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayOrder whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayOrder whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayOrder whereIsPay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayOrder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayOrder whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayOrder wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $hash
 * @property-read mixed $return_url
 * @property-read mixed $title
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayOrder whereHash($value)
 */
class PayOrder extends Model
{
    protected $guarded = [];


    public function getTitleAttribute($value)
    {
        return 'Оплата счёта №' . $this->number;

    }


    public function getReturnUrlAttribute($value)
    {
        return url('/pay/success/'.$this->hash);
    }

}
