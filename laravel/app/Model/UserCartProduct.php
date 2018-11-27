<?php

namespace App\Model;


/**
 * App\Model\UserCartProduct
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $quantity
 * @property int $ordered
 * @property int $send
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereOrdered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereSend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereUserId($value)
 * @mixin \Eloquent
 */
class UserCartProduct extends Model
{
    //
}
