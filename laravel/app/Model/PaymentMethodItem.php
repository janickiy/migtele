<?php

namespace App\Model;


/**
 * App\Model\PaymentMethodItem
 *
 * @property int $id
 * @property int $payment_method_id
 * @property string|null $name
 * @property int|null $sort
 * @property int|null $hide
 * @property-read mixed $img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem whereSort($value)
 * @mixin \Eloquent
 */
class PaymentMethodItem extends Model
{
    public function getImgAttribute()
    {
        $file_path =  '/uploads/payment_methods/'.$this->id.'.jpg';

        return @file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_path) ? $file_path : '';
    }

    /**
     * Scopes
     */

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort($query)
    {
        return $query->orderBy('sort');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('hide', 0);
    }
}
