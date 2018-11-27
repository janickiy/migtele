<?php

namespace App\Model;



/**
 * App\Model\VendorDiscount
 *
 * @property int $id
 * @property int $vendor_id
 * @property int $value
 * @property int $quantity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VendorDiscount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VendorDiscount whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VendorDiscount whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VendorDiscount whereVendorId($value)
 * @mixin \Eloquent
 */
class VendorDiscount extends Model
{
    public $timestamps = false;
}
