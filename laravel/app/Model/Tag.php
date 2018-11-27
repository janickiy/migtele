<?php

namespace App\Model;


/**
 * App\Model\Tag
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $hide
 * @property Category $category
 * @property SubCategory $sub_category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereSlug($value)
 * @mixin \Eloquent
 * @property int|null $category_id
 * @property int|null $subcategory_id
 * @property string|null $text
 * @property string|null $delivery_text
 * @property string|null $warranty_text
 * @property string|null $title
 * @property string|null $description
 * @property string|null $keywords
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereDeliveryText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereWarrantyText($value)
 * @property-read mixed $url
 */
class Tag extends Model
{


    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function sub_category()
    {
        return $this->hasOne(SubCategory::class, 'id', 'subcategory_id');
    }


    public function getUrlAttribute()
    {
        return '/tags/'.$this->slug.'.html';
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
