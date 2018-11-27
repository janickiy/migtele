<?php

namespace App\Model;


/**
 * App\Model\PaymentMethod
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $type
 * @property int|null $sort
 * @property int|null $hide
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\PaymentMethodItem[] $items
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereType($value)
 * @mixin \Eloquent
 */
class PaymentMethod extends Model
{

    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(PaymentMethodItem::class);
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
