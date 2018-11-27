<?php

namespace App\Model;


/**
 * App\Model\ProductImages
 *
 * @property int $id
 * @property int $id_goods
 * @property string $text
 * @property int $sort
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductImages sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductImages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductImages whereIdGoods($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductImages whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductImages whereText($value)
 * @mixin \Eloquent
 * @property-read \App\Model\Product $product
 */
class ProductImages extends Model
{
    protected $table = 'goods_img';



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

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'id_goods');
    }

}

