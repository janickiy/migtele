<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

/**
 * App\Model\Category
 *
 * @property int $id
 * @property int $id_otr
 * @property string $name
 * @property string $text
 * @property int $sort
 * @property string $feature
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property int $status
 * @property int|null $clickCount
 * @property string $slug
 * @property string $url
 * @property string $warranty_text
 * @property string $delivery_text
 * @property array $product_category_ids
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereClickCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereFeature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereIdOtr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereTitle($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\SubCategory[] $sub_categories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category mainSort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category published()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Vendor[] $vendors
 * @property string|null $banner_url
 * @property-read mixed $banner_img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category industry($id_otr)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereBannerUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereDeliveryText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereWarrantyText($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $interested_products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Slider[] $sliders
 * @property-read \App\Model\Otrasl $otrasl
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Tag[] $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category search($search_text)
 */
class Category extends Model
{
    protected $table = 'cattype';

    public $timestamps = false;


    public function getMorphClass()
    {
        return 'category';
    }


    /**
     * Relations
     */

    public function otrasl()
    {
        return $this->belongsTo(Otrasl::class, 'id_otr', 'id');
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function sliders()
    {
        return $this->morphToMany(Slider::class, 'entity', 'entity_slider')->published()->sort();
    }

    /**
     * @return BelongsToMany
     */
    public function sub_categories()
    {

        return $this->belongsToMany(SubCategory::class, 'cattmr', 'id_cattype', 'id_catrazdel')->where('cattmr.hide', 0)->where('catrazdel.hide', 0)->orderBy('name');

    }

    /**
     * @return BelongsToMany
     */
    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'cattmr', 'id_cattype', 'id_catmaker')->where('cattmr.hide', 0)->where('catmaker.hide', 0)->orderBy('name');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class)->where('subcategory_id', 0);
    }

    /**
     * Accessors
     */

    public function getUrlAttribute()
    {
        return $this->slug . '/';
    }

    public function getBannerImgAttribute()
    {
        $file_path = '/img/banner/'.$this->id.'.jpg';

        return @file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_path) ? $file_path : '';
    }


    public function getInterestedProductsAttribute()
    {

        $product_category_ids = $this->product_category_ids;

        return Product::categoryIds($product_category_ids)
            ->inRandomOrder()
            ->limit(10)->get();

    }

    public function getProductCategoryIdsAttribute()
    {
        return DB::
        table('cattmr')
            ->select('cattmr.id')
            ->join('catrazdel', 'catrazdel.id', '=', 'cattmr.id_catrazdel')
            ->join('catmaker', 'catmaker.id', '=', 'cattmr.id_catmaker')
            ->where([
                'cattmr.id_cattype' => $this->id,
                'cattmr.hide' => 0,
                'catrazdel.hide' => 0,
                'catmaker.hide' => 0,
            ])->pluck('id');


    }


    /**
     * Helpers
     */

    /**
     * @param Vendor $vendor
     * @return string
     */
    public function getUrlWithVendor(Vendor $vendor)
    {
        return $this->url . $vendor->slug . '/';
    }

    /**
     * @param SubCategory $subCategory
     * @return string
     */
    public function getUrlWithSubcategory(SubCategory $subCategory){
        return $this->url . $subCategory->slug . '/';
    }

    /**
     * @param SubCategory $subCategory
     * @param SubCategory $subCategory2
     * @param Vendor $vendor
     * @return string
     */
    public function getUrlSubcategory2(SubCategory $subCategory, $subCategory2, $vendor = null){

        return ($vendor ? $this->getUrlWithVendor($vendor) : $this->url) . $subCategory->slug . '/' . $subCategory2->slug . '/';
    }

    /**
     * @param Vendor $vendor
     * @param SubCategory $subCategory
     * @return string
     */
    public function getUrlWithVendorAndSubcategory(Vendor $vendor, SubCategory $subCategory){
        return $this->getUrlWithVendor($vendor) . $subCategory->slug . '/';
    }


    
    /**
     * Scopes
     */

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param integer $id_otr
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIndustry($query, $id_otr)
    {
        return $id_otr ? $query->where('id_otr', $id_otr) : $query;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMainSort($query)
    {
        return $query->orderBy('sort')->orderBy('id');
    }

    /**
     * @param $query
     * @param $search_text
     * @return mixed
     */
    public function scopeSearch($query, $search_text)
    {
        if(!$search_text) return $query;

        $search_text = '%'.$search_text.'%';

        return $query
            ->where('name', 'like', $search_text)
            ->orWhere('text', 'like', $search_text)
            ->orWhere('title', 'like', $search_text)
            ->orWhere('description', 'like', $search_text)
            ->orWhere('keywords', 'like', $search_text);
    }


    public function setCount()
    {
        $this->clickCount++;
        $this->save();
    }
    
    
    
}
