<?php

namespace App\Model;


/**
 * App\Model\DeliveryMethodItem
 *
 * @property int $id
 * @property int $delivery_method_id
 * @property string $name
 * @property string|null $description
 * @property int|null $hide
 * @property int|null $sort
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem whereDeliveryMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem whereSort($value)
 * @mixin \Eloquent
 */
class DeliveryMethodItem extends Model
{
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
