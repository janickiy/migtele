<?php

namespace App\Model;


/**
 * App\Model\Vendor
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $text
 * @property int $sort
 * @property int $hide
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property int|null $clickCount
 * @property int $hide_in_YML
 * @property string $slug
 * @property string $url
 * @property string $delivery_text
 * @property string $warranty_text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereClickCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereHideInYML($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereTitle($value)
 * @property-read mixed $img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor mainSort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor published()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\SubCategory[] $sub_categories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor alphabet()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor char($char)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $interested_products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Slider[] $sliders
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor sortRelatedVendors($sub_category_ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereDeliveryText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereWarrantyText($value)
 * @property-read mixed $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\VendorDiscount[] $discounts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\VendorDiscount[] $discounts_reverse
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor search($search_text)
 */
class Vendor extends Model
{

    public $timestamps = false;

    protected $table = 'catmaker';


    public function getMorphClass()
    {
        return 'vendor';
    }


    /**
     * Relations
     */

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'cattmr', 'id_catmaker', 'id_cattype')->where('cattype.status', 1)->where('cattmr.hide', 0)->orderBy('name');
    }

    public function sub_categories()
    {
        return $this->belongsToMany(SubCategory::class, 'cattmr', 'id_catmaker', 'id_catrazdel')->where('catrazdel.hide', 0)->where('cattmr.hide', 0)->orderBy('name');
    }

    public function discounts()
    {
        return $this->hasMany(VendorDiscount::class)->orderBy('value');
    }

    public function discounts_reverse()
    {
        return $this->hasMany(VendorDiscount::class)->orderBy('value', 'DESC');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function sliders()
    {
        return $this->morphToMany(Slider::class, 'entity', 'entity_slider')->published()->sort();
    }


    /**
     * Accessors
     */

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return 'brands/' . $this->slug . '/';
    }


    public function getCategoryAttribute()
    {
        return $this->categories[0];
    }

    public function getInterestedProductsAttribute()
    {

        $product_category_ids = $this->category->product_category_ids;

        return Product::categoryIds($product_category_ids)
            ->inRandomOrder()
            ->limit(10)->get();

    }

    public function getImgAttribute()
    {
        $file_path = '/img/vendors/'.$this->id.'.jpg';

        return @file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_path) ? $file_path : '/static/img/noimage.png';
    }






    /**
     * Helpers
     */





    /**
     * @param Category|string $category
     * @param SubCategory|string $subcategory
     * @param SubCategory|string $subcategory2
     * @return string
     */
    public function getUrl($category = '', $subcategory = '', $subcategory2 = '')
    {

        if($category){

            if($subcategory){

                if($subcategory2){
                    return $category->getUrlSubcategory2($subcategory, $subcategory2, $this);
                }

                return $category->getUrlWithVendorAndSubcategory($this, $subcategory);

            }else{

                return $category->getUrlWithVendor($this);

            }

        }else{

            return $this->url;

        }

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
        return $query->where('hide', 0);
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
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAlphabet($query)
    {
        return $query->orderBy('name');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $char
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeChar($query, $char)
    {
        return $query->where('name', 'LIKE', $char.'%');
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


    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $sub_category_ids
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortRelatedVendors($query, $sub_category_ids)
    {

        $sorted_vendor_ids =  \DB::
        table('catmaker')
            ->select(['catmaker.id as catmaker_id'])
            ->join('cattmr', 'cattmr.id_catmaker', '=', 'catmaker.id')
            ->whereIn('id_catrazdel', $sub_category_ids)
            ->groupBy(['catmaker_id'])
            ->orderByRaw('COUNT(id_catrazdel)')
            ->pluck('catmaker_id');

        $ids_ordered = implode(',', $sorted_vendor_ids->toArray());

        return $ids_ordered ? $query->orderByRaw(\DB::raw("FIELD(id, $ids_ordered) DESC"))->whereIn('id', $sorted_vendor_ids->toArray()) : $query->whereRaw('0 = 1');

    }


    /**
     * helpers
     */

    /**
     * @param $category_id
     * @return \Illuminate\Support\Collection
     */
    public function getProductCategoryIdsWithCategoryId($category_id)
    {
        return \DB::
        table('cattmr')
            ->select('cattmr.id')
            ->join('catrazdel', 'catrazdel.id', '=', 'cattmr.id_catrazdel')
            ->where([
                'cattmr.id_cattype' => $category_id,
                'cattmr.id_catmaker' => $this->id,
                'cattmr.hide' => 0,
                'catrazdel.hide' => 0,
            ])->pluck('id');

    }

    /**
     * @param $category_id
     * @param $sub_category_id
     * @return \Illuminate\Support\Collection
     */
    public function getProductCategoryIdsWithCatIdSubCatId($category_id, $sub_category_id)
    {
        return \DB::
        table('cattmr')
            ->select('cattmr.id')
            ->join('catmaker', 'catmaker.id', '=', 'cattmr.id_catmaker')
            ->join('catrazdel', 'catrazdel.id', '=', 'cattmr.id_catrazdel')
            ->where([
                'cattmr.id_cattype' => $category_id,
                'cattmr.id_catrazdel' => $sub_category_id,
                'cattmr.id_catmaker' => $this->id,
                'cattmr.hide' => 0,
                'catmaker.hide' => 0,
                'catrazdel.hide' => 0,
            ])->pluck('id');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getProductCategoryIds()
    {
        return \DB::
        table('cattmr')
            ->select('cattmr.id')
            ->where([
                'cattmr.id_catmaker' => $this->id,
                'cattmr.hide' => 0,
            ])->pluck('id');
    }

    public function setCount()
    {
        $this->clickCount++;
        $this->save();
    }
}
